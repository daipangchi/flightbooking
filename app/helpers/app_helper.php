<?php

/**
* convert hours to hours and mins(ex: 20.58333 => 20hrs 35mins)
* 
* @param mixed $hours
*/
function hour2str($hours) {
    $hr = (int)$hours;
    $min = ceil(($hours - $hr) * 60);
    if($min == 60) {
        $hr++;
        $min = 0;
    }

    return sprintf('%02dh %02dm', $hr, $min);
}
function hour2timerange($hours) {
    $hr = (int)$hours;
    $min = ceil(($hours - $hr) * 60);
    
    return sprintf('%sh %sm', $hr, $min);
}

/**
* customize date string from date and time
* 
* @param mixed $format
* @param mixed $date
* @param mixed $time
*/
function mydate($format, $date, $time='') {
    return date($format, strtotime($date . ' ' . $time));
}

/**
* 
* 
* @param mixed $number
* @return mixed
*/
function format_stops($number) {
    if($number == 1) return 'Direkt';
    
    return ($number-1) . ' byte';
}

function format_price($number, $currency='SEK') {
    return number_format($number, 0, '.', ' ') . ' ' . $currency;
}

/**
* get sort option listed 'price', 'best', 'time'
* 
* @param mixed $str
*/
function get_sort_option($str) {
    if(in_array($str, array('price', 'best', 'time'))) {
        return $str;
    }
    
    return 'price';
}

/**
 * get airline icon
 * check if there is icon in assets/images/airlines, otherwise download icon from www.flygstolar.se
 *
 * @param mixed $code
 */
function airline_icon($code) {
    $iconName = $code . '.png';
    $basePath = 'assets/images/airlines';
    $iconPath = public_path("$basePath/$iconName");
    if(!file_exists($iconPath)) {
        $iconSourceUrl = 'http://www.flygstolar.se/img/airlines/' . $iconName;

        // download icon
        if(mkpath(public_path($basePath)) && check_remote_file($iconSourceUrl)) {
            $remoteFile = fopen($iconSourceUrl, 'rb');
            if ($remoteFile) {
                $localFile = fopen($iconPath, "wb");
                if ($localFile) {
                    while(!feof($remoteFile)) {
                        fwrite($localFile, fread($remoteFile, 1024 * 8 ), 1024 * 8 );
                    }
                    fclose($localFile);
                }
                fclose($remoteFile);
            } else {
                $iconName = 'Default.png';
            }
        } else {
            $iconName = 'Default.png';
        }
    }

    return asset("$basePath/$iconName");
}

/**
 * get airline icon
 * check if there is icon in assets/images/airlines, otherwise download icon from www.flygstolar.se
 *
 * @param mixed $code
 */
function agency_icon($code) {
    $iconName = $code . '.png';
    $basePath = 'assets/images/agency';
    $iconPath = public_path("$basePath/$iconName");
    if(!file_exists($iconPath)) {
        $iconSourceUrl = 'http://www.flygstolar.se/img/agents/' . $iconName;

        // download icon
        if(mkpath(public_path($basePath)) && check_remote_file($iconSourceUrl)) {
            $remoteFile = fopen($iconSourceUrl, 'rb');
            if ($remoteFile) {
                $localFile = fopen($iconPath, "wb");
                if ($localFile) {
                    while(!feof($remoteFile)) {
                        fwrite($localFile, fread($remoteFile, 1024 * 8 ), 1024 * 8 );
                    }
                    fclose($localFile);
                }
                fclose($remoteFile);
            } else {
                $iconName = 'Default.png';
            }
        } else {
            $iconName = 'Default.png';
        }
    }

    return asset("$basePath/$iconName");
}

/**
 * check if remote file is exist
 *
 * @param mixed $url
 */
function check_remote_file($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $retCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    // $retcode >= 400 -> not found, $retcode = 200, found.
    curl_close($ch);

    return $retCode == 200 ? true : false;
}

/**
 * get slug from city name
 *
 * @param $name
 * @return mixed
 */
function name2slug($name) {
    $replaceChars = array(' ', 'å', 'ä', 'ö');
    $replaceWithChars = array('-', 'a', 'a', 'o');

    return str_replace($replaceChars, $replaceWithChars, strtolower($name));
}

function internal_link_from_slug($slug) {
    if($slug == '#') return $slug;

    return '/' . $slug . '/';
}

function internal_link_from_url($url) {
    if($url == '#') return $url;

    return $url . '/';
}

if(!function_exists('mkpath'))
{
    /**
     * make directory by given string
     *
     * @param $path
     * @param bool $index
     * @return bool
     */
    function mkpath($path, $index=true)
    {
        if($index) {
            if (@cmkdir($path) or file_exists($path)) return true;
        } else {
            if (@mkdir($path) or file_exists($path)) return true;
        }
        return (mkpath(dirname($path)) and cmkdir($path));
    }
    function cmkdir($path)
    {
        $result = mkdir($path);
        if($result)
        {
            if(!file_exists($path . '/index.html'))
            {
                $str = '<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>';

                $file = fopen($path . '/index.html', 'w');
                fwrite($file, $str);
                fclose($file);
            }
        }

        return $result;
    }
}

if(!function_exists('get_departure_city_feeds')) {
    function get_departure_city_feeds($departureCityCode)
    {
        $feedUrl = 'http://www.sistaminutenresor.com/api/flygresor/' . $departureCityCode;
        $content = file_get_contents($feedUrl);
        return json_decode($content);
    }
}

if(!function_exists('get_destination_city_feeds_by_slug')) {
    function get_destination_city_feeds_by_slug($destinationCitySlug)
    {
        $feedUrl = 'http://www.sistaminutenresor.com/api/destination-by-slug/' . $destinationCitySlug;
        $content = file_get_contents($feedUrl);
        return json_decode($content);
    }
}

if(!function_exists('get_destination_city_feeds_by_code')) {
    function get_destination_city_feeds_by_code($destinationCityCode)
    {
        $feedUrl = 'http://www.sistaminutenresor.com/api/destination-by-airport/' . $destinationCityCode;
        $content = file_get_contents($feedUrl);
        return json_decode($content);
    }
}

if(!function_exists('get_affliate_booking_url')) {
    function get_affliate_booking_url($feedRow)
    {
        $url = $feedRow->booking;
        switch($feedRow->agent_id) {
            case 1:
                $url = 'http://ad.doubleclick.net/ddm/clk/282355158;109182719;m?' . $url;
                break;
            case 2:
                $url = str_replace('&agentlogin=&agentpw=', '', $url) . '&AgentId=141';
                break;
            case 3:
                $code = (substr($url, -1) == 'x') ? '?AgentCode=WEST01' : '&AgentCode=WEST01';
                $url = str_replace(array('&agentcode=', '&AgentCode='), '', $url) . $code;
                break;
            case 10:
                $url = 'http://www.ving.se/redir/PartnerRedirect.aspx?userid=OY59&url=' . $url;
                $url = $url . '&utm_campaign=sistaminutenresor.com&utm_medium=affiliate&utm_source=sistaminutenresor.com&utm_content=resesok';
                break;
            case 5:
                $url = $url . '&p-agentpriv=00842&p-saljarepriv=SIT';
                break;
            case 6:
                $url = $url;
                break;
            case 7:
                $url = $url;
                break;
            case 8:
                break;
            case 9:
                $url = $url . '&RefID=SMINSE&_$ja=tsid:68936';
                break;
        }

        return $url;
    }
}