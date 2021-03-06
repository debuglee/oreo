<?php
namespace Hqbox\Oreo;

class Oreo
{

    public function __construct()
    {

    }
    
    /**
     * 统一返回值格式
     */
    public function formResponseData($data = array(), $message='success', $code=200)
    {
        return array(
            'code'    => $code,
            'message' => $message,
            'data'    => $data
        );
    }

    /**
     * [is_local description]
     *
     * 判断是否是本地测试环境
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:06:53+0800
     * @return   boolean                     [description]
     */
    public static function is_local()
    {
        return PHP_OS == 'Darwin';
    }

    /**
     * [get_client_ip description]
     *
     * 获取客户端ip
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:07:18+0800
     * @return   String
     */
    public static function get_client_ip()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']))
        {
             $onlineip = $_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        {
             $onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        elseif (isset($_SERVER['REMOTE_ADDR']))
        {
             $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        else
        {
            return 'unknown';
        }

        return filter_var($onlineip, FILTER_VALIDATE_IP) !== false ? $onlineip : 'unknown';
    }

    /**
     * [only_chinese_and_word description]
     *
     * 检查内容中是否只有中文
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:07:35+0800
     * @param    [type]                      $string [description]
     * @return   String
     */
    public static function only_chinese_and_word($string)
    {
        $chinese = "(?:[".chr(228)."-".chr(233)."][".chr(128)."-".chr(191)."][".chr(128)."-".chr(191)."])";
        $string = preg_replace("/$chinese/", '', $string);
        return !preg_match("/\W/", $string);
    }


    /**
     * [real_server_ip description]
     *
     * 获取服务器的ip
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:07:45+0800
     * @return   String
     */
    public static function real_server_ip()
    {
        static $serverip = NULL;

        if ($serverip !== NULL)
        {
            return $serverip;
        }

        if (isset($_SERVER))
        {
            if (isset($_SERVER['SERVER_ADDR']))
            {
                $serverip = $_SERVER['SERVER_ADDR'];
            }
            else
            {
                $serverip = '0.0.0.0';
            }
        }
        else
        {
            $serverip = getenv('SERVER_ADDR');
        }

        return $serverip;
    }

    /**
     * [is_email description]
     *
     * is email 判断电子邮件格式
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:08:29+0800
     * @param    String                      $email 电子邮箱
     * @return   boolean                            正确返回true 错误返回false
     */
    public static function is_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
        {
            return false;
        }

        return true;
    }


    /**
     * [sub_str description]
     *
     * 截取字符串
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:09:39+0800
     * @param    String                      $str    需要截取的字符串
     * @param    integer                     $length 截取长度
     * @return   String                              截取结果
     */
    public static function sub_str($str, $length = 0){
        $return_str = "";//返回的字符串
        $len = mb_strlen($str,'utf8');// 以utf-8格式求字符串的长度，每个汉字算一个长度
        if ( $len > $length ){
            $omit = "...";
        }else{
            $length = $len;
        }

        for ($i = 0; $i < $length; $i++) {
            $curr_char = mb_substr($str,$i,1,'utf8');//以utf-8格式取得第$i个位置的字符，取的长度为1
            $curr_length = ord($curr_char) > 127 ? 2 : 1;//如果大于127，则此字符为汉字，算两个长度
            $return_str .= $curr_char;
        }

        return $return_str.$omit;
    }

    /**
     * [bin_convert description]
     *
     * 2, 4, 8, 16, 32 ,64 进制互转
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:11:10+0800
     * @param    String                      $str 需转换数据
     * @param    String                      $n1  转换进制
     * @param    String                      $n2  转换进制
     * @return   String
     */
    public static function bin_convert($str, $n1, $n2)
    {
        $arr_2 = array('0', '1');
        $arr_4 = array('00', '01', '10', '11');
        $arr_8  = array('000', '001', '010', '011', '100', '101', '110', '111');
        $arr_16 = array('0000', '0001', '0010', '0011', '0100', '0101', '0110', '0111', '1000', '1001', '1010', '1011', '1100', '1101', '1110', '1111');
        $arr_32 = array('00000', '00001', '00010', '00011', '00100', '00101', '00110', '00111','01000', '01001', '01010', '01011', '01100', '01101', '01110', '01111','10000', '10001', '10010', '  10011', '10100', '10101', '10110', '10111','11000', '11001', '11010', '11011', '11100', '11101', '11110', '11111');
        $arr_64 = array('000000', '000001', '000010', '000011', '000100', '000101', '000110', '000111', '001000', '001001', '001010', '001011', '001100', '001101', '001110', '001111','010000', '  010001', '010010', '010011', '010100', '010101', '010110', '010111', '011000', '011001', '011010', '011011', '011100', '011101', '011110', '011111','100000', '100001', '100010', '   100011', '100100', '100101', '100110', '100111', '101000', '101001', '101010', '101011', '101100', '101101', '101110', '101111','110000', '110001', '110010', '110011', '110100', '    110101', '110110', '110111', '111000', '111001', '111010', '111011', '111100', '111101', '111110', '111111');
        $char_arr = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f','g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v','w', 'x', ' y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L','M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '_', '.');
        $result_str = '';
        $s = '';
        $a = '';
        switch ($n1)
        {
            case 2 :
                $arr = $arr_2;
                break;
            case 4 :
                $arr = $arr_4;
                break;
            case 8 :
                $arr = $arr_8;
                break;
            case 16 :
                $arr = $arr_16;
                break;
            case 32 :
                $arr = $arr_32;
                break;
            case 64 :
                $arr = $arr_64;
                break;
        }
        switch ($n2)
        {
            case 2 :
                $arrt = $arr_2;
                $b = 1;
                break;
            case 4 :
                $arrt = $arr_4;
                $b = 2;
                break;
            case 8 :
                $arrt = $arr_8;
                $b = 3;
                break;
            case 16 :
                $arrt = $arr_16;
                $b = 4;
                break;
            case 32 :
                $arrt = $arr_32;
                $b = 5;
                break;
            case 64 :
                $arrt = $arr_64;
                $b = 6;
                break;
        }
        for ($i = 0; $i < strlen($str); $i++)
        {
            $s .= $arr[array_search($str[$i], $char_arr)];
        }
        for ($i = 0; $i < $b - strlen($s) % $b; $i++)
        {
            $a .= '0';
        }
        $s = $a . $s;
        for ($i = 0; $i < strlen($s); $i += $b)
        {
            $result_str .= $char_arr[array_search(substr($s, $i, $b), $arrt)];
        }
        for($i = 0; $i < strlen($result_str); $i++)
        {
            if($result_str[$i] != '0')
            {
                return substr($result_str, $i);
            }
        }
    }

    /**
     * [random description]
     *
     * 生成随机串
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:13:05+0800
     * @param    String                      $length 长度
     * @return   String                              转换结果
     */
    public static function random($length) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        $hash = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($chars) - 1;
        for($i = 0; $i < $length; $i++)
        {
            $hash .= $chars[mt_rand(0, $max)];
        }

        return $hash;
    }

    /**
     * [size_format description]
     *
     * 格式化文件大小格式
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:13:54+0800
     * @param    String                      $size 文件大小
     * @param    integer                     $dec  转换单位
     * @return   [type]                            [description]
     */
    public static function size_format($size, $dec = 0)
    {
      $prefix = array('Byte', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
      $size   = round($size, $dec);

      $i = 0;
      while ($size >= 1024)
      {
         $size /= 1024;
         ++$i;
      }

      return round($size, $dec) . $prefix[$i];
    }

    /**
     * [encrypt description]
     *
     * 生产加密字符串
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:15:58+0800
     * @param    String                      $encrypt 字符串内容
     * @return   String
     */
    public static function encrypt($encrypt)
    {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB), MCRYPT_RAND);
        $passcrypt = mcrypt_encrypt(MCRYPT_DES, KEY, $encrypt, MCRYPT_MODE_ECB, $iv);

        return $passcrypt;
    }

    /**
     * [decrypt description]
     *
     * 解密 encrypt 生成的字符串
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:16:28+0800
     * @param    String                      $passcrypt 需解密字符串
     * @return   String
     */
    public static function decrypt($passcrypt)
    {
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_DES, MCRYPT_MODE_ECB), MCRYPT_RAND);
        $encrypt = mcrypt_decrypt(MCRYPT_DES, KEY, $passcrypt, MCRYPT_MODE_ECB, $iv);

        return $encrypt;

    }

    /**
     * [formatDateToTimestamp description]
     *
     * 日期转换时间戳
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:17:50+0800
     * @param    String                      $date 日期 格式必须是2011-06-05
     * @return   String                            时间戳
     */
    public static function formatDateToTimestamp($date) {
        if (empty($date)) {
            return false;
        }
        $str_date = explode('-', $date);
        $year = $str_date[0];//取得年份

        $month = $str_date[1];//取得月份

        $day = $str_date[2];//取得几号

        return mktime(0,0,0,$month,$day,$year);
    }

    /**
     * [format_date description]
     *
     * 格式化日期,按照几秒前，几分钱，几小时前显示
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:18:33+0800
     * @param    String                      $date 时间戳
     * @return   String                            格式化日期
     */
    public static function format_date($date)
    {
        $limit = abs(time() - $date);

        $map = array(
            array(0, 60, '秒钟之前',),
            array(60, 3600, '分钟之前',),
            array(3600, 86400, '小时之前',),
            array(86400, 604800, '天之前',),
            array(604800, 2592000, '周之前',),
            array(2592000, 31536000, '月之前',),
            array(31536000, 0, '年之前',)
        );

        $v = array();
        foreach($map as $v){
            if ($limit < $v[1]){
                return $limit > 60 ? floor($limit/$v[0]) . $v[2] : $limit . $v[2];
            }
        }
        return floor($limit/$v[0]) . $v[2];
    }

    /**
     * [getFirstChar description]
     *
     * 获得汉字的拼音首字母
     *
     * @Author   Debuglee<li.leon@gmail.com>
     * @DateTime 2018-10-17T10:20:04+0800
     * @param    [type]                      $s0 汉字
     * @return   [type]                          返回拼音
     */
    public static function getFirstChar($s0)
    {
        if (isset($s0{0})) {
            $fchar = ord($s0{0});
            if($fchar>=ord("A") and $fchar<=ord("z") )return strtoupper($s0{0});

            $s=iconv("UTF-8","gb2312", $s0);
            $asc=ord($s{0})*256+ord($s{1})-65536;
            if($asc>=-20319 and $asc<=-20284)return "A";
            if($asc>=-20283 and $asc<=-19776)return "B";
            if($asc>=-19775 and $asc<=-19219)return "C";
            if($asc>=-19218 and $asc<=-18711)return "D";
            if($asc>=-18710 and $asc<=-18527)return "E";
            if($asc>=-18526 and $asc<=-18240)return "F";
            if($asc>=-18239 and $asc<=-17923)return "G";
            if($asc>=-17922 and $asc<=-17418)return "I";
            if($asc>=-17417 and $asc<=-16475)return "J";
            if($asc>=-16474 and $asc<=-16213)return "K";
            if($asc>=-16212 and $asc<=-15641)return "L";
            if($asc>=-15640 and $asc<=-15166)return "M";
            if($asc>=-15165 and $asc<=-14923)return "N";
            if($asc>=-14922 and $asc<=-14915)return "O";
            if($asc>=-14914 and $asc<=-14631)return "P";
            if($asc>=-14630 and $asc<=-14150)return "Q";
            if($asc>=-14149 and $asc<=-14091)return "R";
            if($asc>=-14090 and $asc<=-13319)return "S";
            if($asc>=-13318 and $asc<=-12839)return "T";
            if($asc>=-12838 and $asc<=-12557)return "W";
            if($asc>=-12556 and $asc<=-11848)return "X";
            if($asc>=-11847 and $asc<=-11056)return "Y";
            if($asc>=-11055 and $asc<=-10247)return "Z";
            return null;
        } else{
            return null;
        }
    }
}
