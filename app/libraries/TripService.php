<?php

/**
* Get TripService by Soap
*/
class TripService {
    private $isSandboxMode = false;
    private $errorMessage = '';
    
    private $endableCache = true;
    private $dubugMode = false;
    
    private $searchFilters = false;
    private $currency = 'USD';
    private $language = 'EN';
    private $pageLimit = 10;
    
    /**
    * disable cache
    * 
    */
    public function disableCache() {
        $this->endableCache = false;
        return $this;
    }
    
    /**
    * set sandbox test mode
    * 
    */
    public function setSandboxMode() {
        $this->isSandboxMode = true;
        return $this;
    }

    /**
     * set debug mode
     *  * print soap request
     *
     * @return $this
     */
    public function setDebugMode() {
        $this->dubugMode = true;
        return $this;
    }
    
    /**
    * add search filters to get request
    * 
    * @param mixed $filters
    * @return TripService
    */
    public function addFilters($filters) {
        if(!is_array($filters)) {
            return;
        }
        
        $this->searchFilters = $filters;
        return $this;       
    }
    
    /**
    * set currency for request
    * 
    * @param mixed $currency
    * @return TripService
    */
    public function setCurrency($currency) {
        $this->currency = $currency;
        return $this;
    }
    
    /**
    * set languate for request
    * 
    * @param mixed $language
    * @return TripService
    */
    public function setLanguage($language) {
        $this->language = $language;
        return $this;
    }
    
    /**
    * set page limit
    * 
    * @param mixed $limit
    * @return TripService
    */
    public function setPageLimit($limit) {
        $this->pageLimit = $limit;
        return $this;
    }
    
    /**
    * get error message when fail
    * 
    */
    public function getErrorMessage() {
        return $this->errorMessage;
    }
    
    /**
    * Run GetAirportByPrefix from AtlasTravel Service API 
    * 
    * @param mixed $term
    */
    public function getAirportByPrefix($term) {
        $params = [
            'prefix'        => $term,
            'languageCode'  => $this->language
        ];

        $this->endableCache = false;
        return $this->getResponse('GetAirportByPrefix', $params);
    }
    
    /**
    * Run GetTripSearch from AtlasTravel Service API
    * 
    */
    public function getTripSearch() {
        //check if request is valid
        if(!$this->checkFilters()) {
            return false;
        }

        // check start date is less than today
        // calculate cache time
        $startDate = strtotime($this->searchFilters['start']);
        $todayDate = strtotime(date('Y-m-d', time()));
        $cacheTime = 1440;
        $hour = date('H');
        if($startDate < $todayDate) {
            return null;
        } else {
            if($startDate == $todayDate) {
                if($hour < 12) {
                    $cacheTime = (12 - $hour) * 60;
                } else {
                    $cacheTime = (24 - $hour) * 60;
                }
            } else {
                $cacheTime = (int)(($startDate - $todayDate) / 60) - $hour * 60;
            }
        }

        $params = [
            'IATAFrom'  => $this->searchFilters['IATAFrom'],
            'IATATo'    => $this->searchFilters['IATATo'],
            'start'     => $this->searchFilters['start'],
            'end'       => $this->searchFilters['end'],
            'oneWay'    => ($this->searchFilters['oneWay'] === true) ? true : false,
            'numAdults' => $this->searchFilters['numAdults'],
            'limit'     => $this->pageLimit,
            'currencyCode' => $this->currency,
            'languageCode' => $this->language,
            'multiCity' => ($this->searchFilters['multiCity'] == true) ? true : false,
            //'clientId'  => ATLAS_CLIENT_ID,
            'clientId'  => isset($this->searchFilters['clientId']) ? $this->searchFilters['clientId'] : ATLAS_CLIENT_ID,
        ];

        if($children = $this->makeList($this->searchFilters['children'])) {
            $params['children'] = $children;
        }
        if($params['oneWay'] === true) {
            unset($params['end']);
        }

        return $this->getResponse('GetTripSearch', $params, $cacheTime-70);
    }
    
    /**
    * Run GetTripsWithSessionAndFilter from AtlasTravel Service API
    * 
    */
    public function getTripsWithSessionAndFilter() {
        //check if request is valid
        if(!$this->checkFilters()) {
            return false;
        }

        // check start date is less than today
        // calculate cache time
        $startDate = strtotime($this->searchFilters['start']);
        $todayDate = strtotime(date('Y-m-d', time()));
        $cacheTime = 1440;
        $hour = date('H');
        if($startDate < $todayDate) {
            return null;
        } else {
            if($startDate == $todayDate) {
                if($hour < 12) {
                    $cacheTime = (12 - $hour) * 60;
                } else {
                    $cacheTime = (24 - $hour) * 60;
                }
            } else {
                $cacheTime = (int)(($startDate - $todayDate) / 60) - $hour * 60;
            }
        }

        $params = [
            'IATAFrom'  => $this->searchFilters['IATAFrom'],
            'IATATo'    => $this->searchFilters['IATATo'],
            'start'     => $this->searchFilters['start'],
            'end'       => $this->searchFilters['end'],
            'oneWay'    => ($this->searchFilters['oneWay'] == true) ? true : false,
            'numAdults' => $this->searchFilters['numAdults'],
            'limit'     => $this->pageLimit,
            'languageCode'      => $this->language,
            'currencyCode'      => $this->currency,
            'multiCity'         => ($this->searchFilters['multiCity'] == true) ? true : false,
            //'clientId'          => ATLAS_CLIENT_ID,
            'clientId'  => isset($this->searchFilters['clientId']) ? $this->searchFilters['clientId'] : ATLAS_CLIENT_ID,
            'sessionId'         => $this->searchFilters['sessionId'],
            'sortOption'        => 'price',
            'offset'            => $this->searchFilters['offset'],
            'sortOption'        => $this->searchFilters['sortOption'],
            //'selectedMaxPrice'  => $this->searchFilters['selectedMaxPrice'],
            //'selectedFlightStops'       => $this->searchFilters['selectedFlightStops'],
            //'selectedDepatureTimeRange' => $this->makeList($this->searchFilters['selectedDepatureTimeRange']),
            //'selectedReturnTimeRange'   => $this->makeList($this->searchFilters['selectedReturnTimeRange']),
            //'selectedAirlines'          => $this->searchFilters['selectedAirlines'],
            //'selectedAgencys'           => $this->searchFilters['selectedAgencys'],
            
        ];
        
        if($children = $this->makeList($this->searchFilters['children'])) {
            $params['children'] = $children;
        }
        if($this->searchFilters['selectedMaxPrice'] > 0) {
            $params['selectedMaxPrice'] = $this->searchFilters['selectedMaxPrice'];
        }
        if($this->searchFilters['selectedFlightStops'] != 'any') {
            $params['selectedFlightStops'] = $this->searchFilters['selectedFlightStops'];
        }
        if($departureTimeRange = $this->makeList($this->searchFilters['selectedDepartureTimeRange'])) {
            $params['selectedDepartureTimeRange'] = $departureTimeRange;
        }
        if($returnTimeRange = $this->makeList($this->searchFilters['selectedReturnTimeRange'])) {
            $params['selectedReturnTimeRange'] = $returnTimeRange;
        }
        if($airlines = $this->makeList($this->searchFilters['selectedAirlines'])) {
            $params['selectedAirlines'] = $airlines;
        }
        if($params['oneWay'] === true) {
            unset($params['end']);
        }
    
        return $this->getResponse('GetTripsWithSessionAndFilter', $params, $cacheTime-70);
    }
    
    ///////////////////////////////////////////////////////////////////////////////////
    // Private Functions
    ///////////////////////////////////////////////////////////////////////////////////
    
    /**
    * get feed url by mode type
    * 
    */
    private function getFeedUrl() {
        if($this->isSandboxMode == false) {
            return "http://www.flygstolar.se/Service/AtlasTravelEngineService.svc?wsdl";
        } else {
            return "http://traveldigger.com/Service/AtlasTravelEngineService.svc?wsdl";
        }
    }
    
    /**
    * check required filters are exist
    * 
    */
    private function checkFilters() {
        if(empty($this->searchFilters)) {
            $this->errorMessage = 'There is no filters.';
            return false;
        }        
        
        // check required fields
        $requiredFilters = array('IATAFrom', 'IATATo', 'start', 'end', 'oneWay', 'numAdults', 'multiCity'/*, 'clientId'*/);
        foreach($requiredFilters as $key) {
            if(!array_key_exists($key, $this->searchFilters)) {
                $this->errorMessage = sprintf('%s is required filter.', $key);
                return false;
            }                
        }
        
        return true;
    }
    
    private function makeList($list) {
        if(!is_array($list) || count($list) == 0) {
            return '';
        }

        return $list;
    }
    
    /**
    * get soap response
    * 
    * @param mixed $endPoint
    * @param mixed $params
    * @param mixed $cacheTime
    */
    private function getResponse($endPoint, $params, $cacheTime=1440) {
        $response = null;
        $cacheKey = $endPoint . md5(json_encode($params));

        // check cache and return if it's exist
        if($this->endableCache && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            // get response from service every time
            if($this->dubugMode) {
                $request = new SoapClient($this->getFeedUrl(), array('trace' => 1));
                $request->__soapCall($endPoint, [$params]);
                var_dump($request->__getLastRequest());
                exit;
            } else {
                $request = new SoapClient($this->getFeedUrl());
                $response = $request->__soapCall($endPoint, [$params]);

                // save response to cache
                if($this->endableCache && $response) {
                    Cache::put($cacheKey, $response, $cacheTime);
                }
            }

            // return
            return $response;
        } catch (Exception $e) {
            $this->errorMessage = 'Soap Error. Try again.';
            return false;
        }            
    }
}