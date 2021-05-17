<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Session\Session;

class ApiGiftsetProductVariantController extends Controller
{
    //
    public function storeGiftsetPvSession($currentPagination, $id, $status, $paginationPageName){
        // The key of session is the current number of pagination and it's 
        // contained array of checked productvariants. 
        // ApiGiftsetProductVariantController::clearSessionData();
        $boolStatus = strtolower($status) == 'true' ? true : false;
        if($boolStatus) {   // store into session
            $isSessionStore = ApiGiftsetProductVariantController::storeSessionData(($currentPagination.'-'.$paginationPageName), $id, $status);

            if($isSessionStore) {
                $isTotalPaginationPageSessionStore = ApiGiftsetProductVariantController::setTotalPaginationPage($paginationPageName, ($currentPagination.'-'.$paginationPageName));

                if($isTotalPaginationPageSessionStore) {
                    $paginationPageArr = ApiGiftsetProductVariantController::getTotalPaginationPage($paginationPageName);
                }

            }

            $isSessionStore ? $message = $paginationPageArr : $message = $currentPagination;
        }
        if(!$boolStatus){   // remove from session if existing
            $isSessionRemove = ApiGiftsetProductVariantController::removeSessionData(($currentPagination.'-'.$paginationPageName), $id);
            
            if($isSessionRemove){
                $paginationPageArr = ApiGiftsetProductVariantController::updateTotalPaginationPage($paginationPageName, ($currentPagination.'-'.$paginationPageName));
            }

            $isSessionRemove ? $message = $paginationPageArr : $message = "error remove from session";
        }

        $response = [
            'Content-type' => 'application/json',
            'status' => 'success',
            'message' => [$message],
        ];

        return response()->json($response);
    }

// =======================================================================
// Product Variants Session That Store Base On pagination Page Number 
// =======================================================================
    /**
     * Store productvariant into session base on pagination page number.
     * @param Integer $currentPagination
     * @param Integer $pvId
     * @param Boolean $status
     * @return Boolean true/false
     */
    public static function storeSessionData($currentPagination, $pvId, $status) {
        $session = new Session();

        if($session->has($currentPagination)) { // add into existing session array
            $pvArrList = $session->get($currentPagination);
            $pvArrList[$pvId] = $status;
            $session->set($currentPagination, $pvArrList);
            return true;

        } else { // store productvariant session for the first time
            $session->set($currentPagination, [$pvId => $status]);
            return true;

        }
        return false; // any unexpected errors
    }

    /**
     * Remove specific productvariant from session base on pagination page number.
     * @param Integer $currentPagination
     * @param Integer $pvId
     * @return Boolean true/false
     */
    public static function removeSessionData($currentPagination, $pvId) {
        $session = new Session();

        // check if session exist
        if($session->has($currentPagination)) {
            $pvArrList = $session->get($currentPagination);
            // check if session has pvId 
            $isPvExist = array_key_exists($pvId, $pvArrList);
            if($isPvExist) {
                // remove and update session
                unset($pvArrList[$pvId]);
                $session->set($currentPagination, $pvArrList);

                return true;
            } else {
                return false;
            }
        }
        return false;
    }

    /**
     * Get total of productvariant that store in each pagination page number.
     * @param Array $paginationArr
     * @return Json_Response $productVariantArr
     */
    public static function getProductVariantArray($paginationArr) {
        $session = new Session();
        $productVariantArr = [];
    
        Log::info(empty($productVariantArr));

        array_map(function($pagination) use ($session, &$productVariantArr){
            $tempProductVariantArr = $session->get($pagination);
            foreach($tempProductVariantArr as $key => $value) {
                array_push($productVariantArr, $key);
            }
        }, $paginationArr);

        return json_encode($productVariantArr);
    }

    /**
     * Clear all session data base on pagination page number.
     * @param Integer $currentPagination
     * @return Boolean true/false
     */
    public static function clearSessionData() {
        $session = new Session();
        $session->clear();
        return true;
    }

    /**
     * Check if provided product variant is checked inside session
     * @param Integer $pageId
     * @param Integer @pvId
     * @return String $checkResult [ 'checked' | '' ]
     */
    public static function isChecked($pageId, $pvId){
        $session = new Session();
        $checkResult = '';

        // check if session existing
        if($session->has($pageId)) {
            $pvArrList = $session->get($pageId);
            $isPvExist = array_key_exists($pvId, $pvArrList);            
            $isPvExist ? $checkResult = 'checked' : $checkResult;
            return $checkResult;
        } else {
            return $checkResult;
        }
    }

// ==================================================
// Pagination Session That Store Product Variants
// ==================================================
    /**
     * Get total of pagination page number that had product variant
     * @param String $paginatinPageName [represent variable that store total paginations number]
     * @return Json_Response $response
     */
    public static function getTotalPaginationPage($paginatinPageName){
        $session = new Session();

        // check if session existing
        if($session->has($paginatinPageName)) {
            $paginationArrList = $session->get($paginatinPageName);
            // $message = json_encode($paginationArrList);
            $message = $paginationArrList;
        } else {
           $message = null;
        }

        return json_encode($message);
    }

    /**
     * Set number of pagination page into array if current stored product variant session.
     * @param String $sessionName
     * @param String $sessionValue
     * @return Boolean true / false
     */
    public static function setTotalPaginationPage($sessionName, $sessionValue){
        $session = new Session;
        
        // checked if session existing
        if($session->has($sessionName)) { // update existing session
            $paginationArr = $session->get($sessionName);

            // $isIndexDuplicate = array_key_exists($paginationIndex-1, $paginationArr);
            $isIndexDuplicate = in_array($sessionValue, $paginationArr);  
            if(!$isIndexDuplicate) {            
                // update data inside session if key is difference
                array_push($paginationArr, $sessionValue);
                $session->set($sessionName, $paginationArr);               
            }
            return true;
        } else { // storing session for the first time
            $session->set($sessionName, array($sessionValue));
            return true;
        }

        // from any error
        return false;
    }

    /**
     * Update number of pagination page from existing session and clear if empty.
     * @param String $sessionName
     * @param Strnig $currentPaginationPageNumber
     * @return Json_Response $response
     */
    public static function updateTotalPaginationPage($sessionName, $currentPaginationPageNumber){
        $session = new Session();
        // productvariants data inside specific pagination page number session
        $pvArrList = $session->get($currentPaginationPageNumber);
        
        // total of pagination page number that has data and it's store inside session
        $paginationArr = $session->get($sessionName);
        
        // check if data empty in current pagination page number session
        if(count($pvArrList) == 0){
            if (($key = array_search($currentPaginationPageNumber, $paginationArr)) !== false) {
                array_splice($paginationArr, $key, 1);
                $session->set($sessionName, $paginationArr);
            }
        }
        
        $message = $session->get($sessionName);
        return json_encode($message);
    }
}