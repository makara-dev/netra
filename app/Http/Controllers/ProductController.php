<?php

namespace App\Http\Controllers;

use App;
use Exception;
use ErrorException;

use App\Product;
use App\Category;
use App\Attribute;
use App\AttributeValue;
use App\ProductVariant;
use App\CustomLibs\ManagesImages;
use App\CustomLibs\ArrayCompare;
use App\Giftset;
use App\Review;
use Dotenv\Exception\InvalidFileException;
use Illuminate\Http\Request;
use Illuminate\Mail\Markdown;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection as SupportCollection;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;
use Throwable;

class ProductController extends Controller
{

    use ManagesImages;
    use ArrayCompare;
    /**
     * Display a listing of products.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $categoryId)
    {
        try {
            $category = App\Category::findOrFail($categoryId);
        } catch (Exception | Throwable $e) {
            return abort(403, 'category not found.');
        }
       

        //get filters
        $filterAttributes = App\Attribute::all();
        $hasFilter = $this->hasFilter($request, $filterAttributes);

        //get products sorted by filter(if has any)
        $products = ($hasFilter)
            ?
            $this->getFilteredProduct($request, $filterAttributes) // filtered
            :
            $category->products; //no filter

        $attributes = $category->selectAllAttributes();

        return view('product.list')
            ->with('products', $products->paginate(8))
            ->with('attributes', $attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id - product id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $attr1 = null, $attr2 = null)
    {
        $attrIds = new SupportCollection();
        // validate attr1 and attr2 
        $prAttr1Id = $attr1 != null ? $attr1 : null;
        $prAttr2Id = $attr2 != null ? $attr2 : null;
        
        $attrIds->prAttr1Id = $prAttr1Id;
        $attrIds->prAttr2Id = $prAttr2Id;

        // get giftsets
        $giftsets = Giftset::inRandomOrder()->limit(4)->get();

        // find product 
        try {
            $product = App\Product::find($id);
        } catch (Exception | Throwable $e) {
            return abort(404, 'Product not found.');
        }

        $reviews = $product->reviews()->orderBy('review_id', 'desc')->paginate(3);
            
        $attributes = $product->selectAttributes();

        //render MD to HTML
        $temp = $product->description;

        $product->description = (empty($temp))
            ? 'No description available'
            : Markdown::parse($product->description);

        return view('product.detail')
            ->with('product', $product)
            ->with('attributes', $attributes)
            ->with('reviews', $reviews)
            ->with('attrIds', $attrIds)
            ->with('giftsets', $giftsets);
    }

    /**
     * get New arrival products
     * @return \Illuminate\Http\Response
     */
    public function newArrival()
    {
        $product = new Product();
        $newProducts = $product
            ->newArrival(7) //a week (7 days)
            ->paginate(10);

        return view('product.list')
            ->with('products', $newProducts)
            ->with('attributes', new Collection()); //empty filter sidebar
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.product.add')
            ->with('categories', Category::all())
            ->with('attributes', Attribute::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'img-file'             => ['required'],
            'costs.*'              => ['required', 'numeric'],
            'prices.*'             => ['required', 'numeric'],
            'productName'          => ['required', 'max:255', 'unique:products,product_name'],
            'category'             => ['required', 'exists:categories,category_id'],
            'productVariantSkus.*' => ['required', 'string', 'distinct'],
        ]);

        try {
            $category = App\Category::findOrFail($request->input('category'));
        } catch (ModelNotFoundException $e) {
            return abort(403, 'cant find model');
        }

        DB::beginTransaction();

        //create product
        $productName = $request->input('productName');
        $description = $request->input('description');

        $product = new Product([
            'product_name' => $productName,
            'description' => $description
        ]);

        // save product
        $product = $category->products()->save($product);
        if (!$product) {
            return back()->with('error', 'Something went wrong while trying to save the product');
        }

        try {
            //store img
            $images = $request->file('img-file');
            if (!$request->hasFile('img-file') && !$images->isValid()) {
                throw new InvalidFileException('Invalid uploaded Image file.');
            }

            $tempImages = $this->storeProductImgs($images, $product);

            $thumbnail     = reset($tempImages);
            $thumbnailFile = reset($images);

            $thumbnail->update(['is_thumbnail' => true]);

            $thumbnailName = basename($thumbnail->path);

            $product->thumbnail = $this->storeThumbnail($thumbnailFile, $thumbnailName);
            $product->update();
        } catch (InvalidFileException | ErrorException $e) {
            DB::rollBack();
            return back()->with('error', ' ERROR SAVING PRODUCT : ' . $e->getMessage());
        }

        //save images
        $imageResult = $product->images()->saveMany($tempImages);
        if (!$imageResult) {
            return back()->with('error', 'Something went wrong while trying to save the Images');
        }

        // save product variant
        try {
            $productVariants = new Collection();
            foreach ($request->input('productVariantRows') as $key) {

                //check for duplicate entry of product variant
                $duplicate = false;
                $attributeValuesId = $request->input("attributeValues")[$key];
                foreach ($productVariants as $pv) {
                    $pvAttrValsId = $pv->attributeValues()->pluck('attribute_values.attribute_value_id')->toArray();
                    
                    //update qty if duplicate
                    if (ArrayCompare::array_equals($pvAttrValsId, $attributeValuesId)) {
                        $pv->update(['quantity' => $pv->quantity + $request->input("quantities")[$key]]);
                        $duplicate = true;
                        break;
                    }
                }

                //add new productvariant if not duplicate
                if (!$duplicate) {
                    $productVariant = new ProductVariant([
                        'product_variant_sku' => $productName,
                        'cost' => $request->input("costs")[$key],
                        'price' => $request->input("prices")[$key],
                        'quantity' => $request->input("quantities")[$key],
                        'created_by' => auth()->user()->staff->staff_id,
                    ]);
                    $productVariant->product()->associate($product);
                    $product->productVariants()->save($productVariant);

                    //attach foreign keys
                    $productVariant->attributeValues()->attach($attributeValuesId);

                    $productVariant->update([
                        'product_variant_sku' =>  $productName . $productVariant->getAttributeValuesName()
                    ]);
                    $productVariants->add($productVariant);
                }
            }
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return back()->with('error', ' ERROR PRODUCT VARIANT : ' . $e->getMessage());
        }

        //save records
        DB::commit();
        return redirect('dashboard/products?_token=' . csrf_token() . '&created_at-sort=desc')->with('success', 'Product has been added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return back()->with('Product Not Found');
        }

        //get color
        $color = null;
        $attrVals = $product->productVariants()->first()->attributeValues;
        foreach ($attrVals as $attrVal) {
            $attr = $attrVal->attribute;
            if ($attr->attribute_name == 'color') {
                $color = $attrVal;
                break;
            }
        }
        
        return view('dashboard.product.edit')
            ->with('product', $product)
            ->with('color', $color)
            ->with('category', $product->category)
            ->with('images', $product->images)
            ->with('thumbnail', $product->getThumbnailObject())
            ->with('productVariants', $product->productVariants);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        try {
            $product = Product::findOrFail($id);
        } catch (ModelNotFoundException $me) {
            return back()->with('error', 'Unable to find product');
        }

        $request->validate([
            'costs.*'     => ['required', 'numeric'],
            'prices.*'    => ['required', 'numeric'],
            'productName' => ['required', 'max:255'],
            'productVariantSkus.*' => ['required', 'string'],
        ]);

        $productName = $request->input('productName');
        $description = $request->input('description');

        DB::beginTransaction();

        //update product
        if ($productName && $productName != $product->product_name) {
            $product->product_name = $productName;
        }
        if ($description && $description != $product->description) {
            $product->description = $description;
        }

        //upate product variants
        foreach ($product->productVariants as $productVariant) {            
            //remove disabled from select options in the blade file for these to work
            // $attributeValueIds = $request->input('attributeValues')[$id];
            
            //update attribute values foreign key
            // $productVariant->attributeValues()->detach(); //remove old key
            // $productVariant->attributeValues()->attach($attributeValueIds);

            $id = $productVariant->product_variant_id;
            
            $productVariant->update([
                'sku'                 => $request->input("productVariantSkus")[$id],
                'cost'                => $request->input("costs")[$id],
                'price'               => $request->input("prices")[$id],
                'quantity'            => $request->input("quantities")[$id],
                'product_variant_sku' => $productName . $productVariant->getAttributeValuesName()
            ]);
        }

        // dd($request->all());
        // dd($request->input("costs")[3]);

        //store new product variant
        try {
            $newAttributeValues = $request->input('productVariantRows');

            if ($newAttributeValues) {
                foreach ($newAttributeValues as $key) {

                    //check for duplicate entry of product variant
                    $duplicate = false;
                    $attributeValuesId = $request->input("newAttributeValues")[$key];

                    foreach ($product->productVariants as $pv) {
                        $pvAttrValsId = $pv->attributeValues()->pluck('attribute_values.attribute_value_id')->toArray();

                        //update qty if duplicate
                        if (ArrayCompare::array_equals($pvAttrValsId, $attributeValuesId)) {
                            $pv->update(['quantity' => $pv->quantity + $request->input("newQuantities")[$key]]);
                            $duplicate = true;
                            break;
                        }
                    }

                    //add new productvariant if not duplicate
                    if (!$duplicate) {
                        $productVariant = new ProductVariant([
                            'product_variant_sku' => $productName,
                            'cost'                => $request->input("newCosts")[$key],
                            'price'               => $request->input("newPrices")[$key],
                            'quantity'            => $request->input("newQuantities")[$key],
                        ]);

                        $product->productVariants()->save($productVariant);

                        //attach new foreign keys
                        $attributeValueId = $request->input("newAttributeValues")[$key];
                        $productVariant->attributeValues()->attach($attributeValueId);

                        $productVariant->update([
                            'product_variant_sku' =>  $productName . $productVariant->getAttributeValuesName()
                        ]);
                    }
                }
            }
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            return back()->with('error', ' ERROR PRODUCT VARIANT : ' . $e->getMessage());
        }

        //update existing images
        if ($request->hasFile('img-file')) {
            $uploads = $request->file('img-file');
            $oldImages = $product->images;

            foreach ($oldImages as $oldImg) {
                $id = $oldImg->image_id;

                if (array_key_exists($id, $uploads)) //check if image exist
                {
                    $upload = $uploads[$id];
                    if ($upload->isValid()) {
                        $filename = $product->product_name . '_' . $product->product_id . '_' . $id . time() . '.' . $upload->getClientOriginalExtension();
                        $newPath = 'images/product/' . $filename;

                        $this->storeImage($upload, $newPath);
                        $this->deleteImageFile($oldImg->path);

                        $oldImg->update(['path' => $newPath]);

                        if ($oldImg->is_thumbnail) {
                            $thumbnailName = basename($oldImg->path);
                            $this->deleteImageFile($product->thumbnail);
                            $product->thumbnail = $this->storeThumbnail($upload, $thumbnailName);
                        }
                    }
                }
            }
        }

        //store new img
        if ($request->hasFile('new-img-file')) {
            $images = $request->file('new-img-file');
            $tempImages = $this->storeProductImgs($images, $product);

            if (!$product->hasThumbnail()) {
                $thumbnail = reset($tempImages);

                $thumbnailFile = reset($images);
                $thumbnailName = basename($thumbnail->path);

                $product->thumbnail = $this->storeThumbnail($thumbnailFile, $thumbnailName);
                $thumbnail->update(['is_thumbnail' => true]);
            }
            $product->images()->saveMany($tempImages);
        }

        $product->touch(); //update timestamp
        $product->update();
        DB::commit();
        return redirect('dashboard/products?_token=' . csrf_token() . '&updated_at-sort=desc')->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $result = $product->delete();
            if (!$result) {
                throw new ErrorException('Something went wrong while trying to get the product');
            }
        } catch (ErrorException | ModelNotFoundException $e) {
            return back()->with('error', $e->getMessage());
        }
        return back()->with('success', 'Item deleted successfully');
    }

    //check filter
    private function hasFilter(Request $request, $productAttributes)
    {
        foreach ($productAttributes as $productAttribute) {
            if ($request->has($productAttribute->attribute_name)) {
                return true;
            }
        }
        return false;
    }

    //get filtered products
    private function getFilteredProduct(Request $request, $attributes)
    {
        //get attributeValue and check request
        try {
            foreach ($attributes as $attribute) {
                //check if user selected any filter
                if ($request->has($attribute->attribute_name)) {

                    $attributeValue = App\AttributeValue::findOrFail($request->input($attribute->attribute_name));
                }
            }
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        //get prooduct variants
        $productVariants = $attributeValue->productVariants;

        //get products
        $products = new Collection();
        foreach ($productVariants as $productVariant) {
            $product = $productVariant->product;
            if ($products->where('product_id', $product->product_id)->count() == 0) {
                $products->add($product);
            }
        }

        return $products;
    }
}