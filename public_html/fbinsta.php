<?php

/*
출처: https://tonhnegod.tistory.com/245 [조용한 웹 개발자]
*/



//액세스 토큰 발급
$url = "https://api.instagram.com/oauth/access_token";
$post_array = array(
    'client_id'=>'2126097737571051',
    'client_secret'=>'8cff56039612adf880432f185e7919df',
    'grant_type'=>'authorization_code',
    'redirect_uri'=>'https://coscorea.com/',
    'code'=>'AQB4p2fsSLZ2yILyXwsKNOWq2J69aWXGnL8KJyDZ1u-dA6tqMCtG44dixPwRR2cYlnQzfH7py-wh-TUT3r0L-4_I6nFqHWlswU594E6OaTfn8Hxy1M875XWkmNwrK8f53CW90iAgzHxcOs2EIi4noLgUPO14nmWcernd4cAeavZppUvKGYm4XqHjkvhlzMMWym3CdPQTpiWlitZmqvMPiEvV5NOuAuCha0fiPMNWEvA_rw#_'
);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST,true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_array);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$result = curl_exec($curl);
curl_close($curl);
$result = json_decode($result,true);
print_r($result);



/*

Array ( [access_token] => IGQVJXNGpmNkdIak1CQ2hyVzNKVEVwZAWdWRUNMM1MweXB2dkNDcGZAxUnR5WjBOQmczbFZAERDk2YndqZAXkxSGFrYXUySzZAuaFJkR3hSbTRnajVnWVJ0QVRjVDBsRUZAXX0E5UmlNMWFDVEo2cTZAGQTBtYURLVFdzZAkZANTlFV [user_id] => 17841447702681825 )



https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=8cff56039612adf880432f185e7919df&access_token=IGQVJXNGpmNkdIak1CQ2hyVzNKVEVwZAWdWRUNMM1MweXB2dkNDcGZAxUnR5WjBOQmczbFZAERDk2YndqZAXkxSGFrYXUySzZAuaFJkR3hSbTRnajVnWVJ0QVRjVDBsRUZAXX0E5UmlNMWFDVEo2cTZAGQTBtYURLVFdzZAkZANTlFV

===>

{
   "access_token": "IGQVJXb0JTUEx5eFZA3SXM4aXZAGLXVucGJZATmc0bWNjU1c4ckJSdW5lVWM2WS1mUWxPeWVSRU9naVhzZAFVFa2hpV19LZA01FRXRNdGJ2SXZATYVpleVRoRHNrMzVDUjEzZAmkweUtTSi1n",
   "token_type": "bearer",
   "expires_in": 5184000
}




http://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token={long-lived-access-token}
출처: https://tonhnegod.tistory.com/245 [조용한 웹 개발자]




출처: https://tonhnegod.tistory.com/245 [조용한 웹 개발자]

=========>

https://graph.instagram.com/17841447702681825/media?fields=id,media_type,media_url,permalink,thumbnail_url,username,caption&access_token=IGQVJXb0JTUEx5eFZA3SXM4aXZAGLXVucGJZATmc0bWNjU1c4ckJSdW5lVWM2WS1mUWxPeWVSRU9naVhzZAFVFa2hpV19LZA01FRXRNdGJ2SXZATYVpleVRoRHNrMzVDUjEzZAmkweUtTSi1n



출처: https://tonhnegod.tistory.com/245 [조용한 웹 개발자]




*/
?>
