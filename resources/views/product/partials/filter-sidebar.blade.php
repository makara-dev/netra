<!-- BEGIN :: FILTER SIDE BAR -->
<div class="filter-sidebar">
    {{-- filter menu --}}
    <form>
        @csrf
        <div class="filter-menu-wrapper">
            <div class="filter-close-btn">x</div>
            <div class="filter-heading-wrapper">
                <label>Filter and Sort</label>
                <span class="filter-toggler-icon"> <img src="{{asset('icon/arrow-down.png')}}" alt="down arrow"> </span>
            </div>
            @foreach ($attributes as $attribute)
            <hr class="filter-hr">
            <div class="form-group" style="height: 140px; overflow: auto;">
                <h5>{{ ucfirst($attribute->attribute_name) }}</h5>
                @foreach ($attribute->attributeValues as $attributeValue)
                <div class="form-check">
                    <input type="checkbox" id="{{$attributeValue->attribute_value_id}}checkbox"
                        name="{{$attribute->attribute_name}}" value="{{$attributeValue->attribute_value_id}}"
                        class="filter-checkbox" />
                    <label for="{{$attribute->attribute_name}}">
                        {{$attributeValue->attribute_value}}
                    </label>
                </div>
                @endforeach
            </div>
            @endforeach
            <hr class="filter-hr" style="margin-left: 2em;">
            <div class="filter-reset-text text-center">
                <a class="cursor-pointer" id="clear-filter-btn">Reset Filter</a>
            </div>
        </div>
    </form>
</div>
<!-- END :: FILTER SIDE BAR -->