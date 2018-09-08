<?php
function getweather(){
    $url = "http://tianqi.moji.com/weather/china/liaoning/dalian";
    $curl =curl_init($url);
    curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1);
    $info = curl_exec($curl);
    curl_close($curl);
    $reginfo = '/href="https:\/\/tianqi\.moji\.com\/today\/china\/liaoning\/dalian">(.|\s)*?(?=(<\/ul>))/';
    $regli = '/(<li>)(.|\s)*?(<\/li>)/';
    $regimgurl = '/(https:).*?(?=")/';  //天气图片url
    //$regchar = '/[^(alt=")a-z].?(?=")/'; //天气中文描述：晴    中文直接匹配有问题，下面均多匹配点再分割的
    $regchar = '/(alt=).*(?=")/'; //"
    $regtemps = '/[-]?[\d]+/';  //温度，第一个数为低温，2为高温，纯数字
    //$regwind = '/[^(<em>)].?(?=(<\/em>))/';  //获取什么风
    $regwind = '/<em>.*(?=<)/'; //>
    //$regwindnum = '/[\d][-][\d].?(?=(<\/b>))/'; //获取：2-6级
    $regwindnum = '/<b>.*(?=<)/'; //>
    //$regair = '/[\d]+\s.{1}/';  //空气质量：39 优
    $regair = '/([\d]+\s).*(?=(\n|\r))/';
    preg_match($reginfo, $info, $getinfo);
    preg_match_all($regli, $getinfo[0], $getli);//<li>1图片和描述，2温度，3风和等级，4空气
    
    $getli = $getli[0];
    preg_match($regchar, $getli[0], $disc);
    preg_match($regimgurl, $getli[0], $imgurl);
    preg_match_all($regtemps, $getli[1], $templow);
    preg_match_all($regtemps, $getli[1], $temphigh);
    preg_match($regwind, $getli[2], $wind);
    preg_match($regwindnum, $getli[2], $windnum);
    preg_match($regair, $getli[3], $air);
    $disc = $disc[0];$disc = explode('"', $disc)[1];
    $wind = $wind[0];$wind = explode('>', $wind)[1];
    $windnum = $windnum[0];$windnum = explode('>', $windnum)[1];
    $air = $air[0];$airnum = explode(' ', $air)[0];
    $airdisc = explode(' ', $air)[1];
    
    $temp['cityname'] = "大连";
    $temp['disc'] = $disc;
    $temp['imgurl'] = $imgurl[0];
    $temp['templow'] = $templow[0][0];
    $temp['temphigh'] = $temphigh[0][1];
    $temp['wind'] = $wind;
    $temp['windnum'] = $windnum;
    $temp['airnum'] = $airnum;
    $temp['airdisc'] = $airdisc;
    
    return $temp;
}
echo "<pre>";
var_dump(getweather());
?>