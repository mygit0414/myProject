<?php

/**
 * 自定义数组常量，在action和html均可直接调用。
 * Enter description here ...
 */

/**
 * 房型
 */
function houseTypeArray(){
	return Array(
	  '一房一厅'=>1, 
	  '二房一厅'=>2, 
	  '三房一厅'=>3, 
	  '四房一厅'=>4, 
	  '二房两厅'=>5, 
	  '三房两厅'=>6,
	  '四房两厅'=>7, 
	  '五房以上'=>8 
	);
}

/**
 * 土地类型
 */
function landTypeArray(){
	return Array(
	  '国有土地'=>1, 
	  '私有土地'=>2
	);
}

/**
 * 物业类型
 */
function propertyTypeArray(){
	return Array(
	  '新房'=>1, 
	  '二手房'=>2, 
	  '商铺'=>3, 
	  '写字楼'=>4, 
	  '租房'=>5, 
	  '厂房'=>6, 
	  '地皮'=>7,
	  '仓库'=>8,
	  '楼盘团购'=>9,
	  '地产其它'=>10
	);
}

/**
 * 朝向
 */
function directionArray(){
	return Array(
	  '东'=>1, 
	  '东南'=>2, 
	  '南'=>3, 
	  '西南'=>4, 
	  '西'=>5, 
	  '西北'=>6, 
	  '北'=>7,
	  '东北'=>8
	);
}

/**
 * 装修
 */
function decorationArray(){
	return Array(
	  '毛坯房'=>1, 
	  '新装修'=>2, 
	  '普通装修'=>3, 
	  '豪华装修 '=>4,
	  '中档装修 '=>5,
	  '精装修 '=>6
	);
}

/**
 * 价格区间
 */
function priceArray(){
	return Array(
	  '20万以下'=>1, 
	  '20-40万'=>2, 
	  '40-60万'=>3, 
	  '60-80万'=>4,
	  '80-100万'=>5, 
	  '100-150万'=>6, 
	  '150-200万'=>7, 
	  '200万以上'=>8
	);
}

/**
 * 面积区间
 */
function areaArray(){
	return Array(
	  '40㎡以下'=>1, 
	  '40-60㎡'=>2, 
	  '60-80㎡'=>3, 
	  '80-100㎡'=>4,
	  '100-120㎡'=>5, 
	  '120-144㎡'=>6, 
	  '144㎡以上'=>7
	);
}

/**
 * 
 * 根据value值获取数组中的key值。
 * @param $arr 数组
 * @param $value 值
 */
function getKey($arr,$value){
	if(!is_array($arr)){
		return null;
	}
	
	foreach($arr as $k =>$v) {
		$return = getKey($v, $value);
		if($v == $value){
			return $k;
		}
	}
	
	if(!is_null($return)){
   		return $return;
	}
}

/**
 * 押金类型
 */
function depositTypeArray(){
	return Array(
	  '不需要押金'=>1, 
	  '付一压一'=>2, 
	  '付一压二'=>3, 
	  '付一压三'=>4,
	  '付一压四'=>5, 
	);
}

/**
 * 价格区间
 */
function rentArray(){
	return Array(
	  '500以下'=>1, 
	  '500-1000'=>2, 
	  '1000-1500'=>3, 
	  '1500-2500'=>4,
	  '2500-3500'=>5, 
	  '3500以上'=>6,
	);
}

/**
 * 销售类型
 */
function saleTypeArray(){
	return Array(
	  '出租'=>1, 
	  '出售'=>2, 
	  '租售均可'=>3,
	);
}

/**
 * 获取随机数
 */
function getRandomkeys($length){
	$pattern='1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
	for($i=0;$i<$length;$i++){
	   $key .= $pattern{mt_rand(0,35)};    //生成php随机数
	}
	return $key;
}

/**
 * utf-8字符串长度
 */
function strlen_utf8($str) {
	$i = 0;
	$count = 0;
	$len = strlen ($str);
	while ($i < $len) {
		$chr = ord ($str[$i]);
		$count++;
		$i++;
		if($i >= $len) break;
		if($chr & 0x80) {
			$chr <<= 1;
			while ($chr & 0x80) {
				$i++;
				$chr <<= 1;
			}
		}
	}
	return $count;
}

/**
 * 计算字符串长度
 */
function abslength($str){
	if(true){
		return 100;
	}
    $len=strlen($str);
    $i=0;
    while($i<$len)
    {
        if(preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$str[$i]))
        {
            $i+=2;
        }
        else
        {
            $i+=1;
        }
    }
    return $i;
}
?>