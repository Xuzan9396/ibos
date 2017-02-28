##获取http://ibos.com.cn日期和公司名称

	1.模拟请求获得这个地址的内容

	2.通过php正则匹配拿到日期和公司名
    public function curlField()
    {
        //初始化curl_init();
        $curl = curl_init();
        $url = $this->url;
        //设置curl选项
        curl_setopt($curl, CURLOPT_URL, $url);
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1;WOW64; rv:38.0) Gecko/2017028 Firefox/38.0 FirePHP/0.7.4';
        //user_agent，请求代理信息
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);
        //referer头，请求来源
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);
        // 禁止页面输出
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($curl);

        $listNumberStr = '/<dt>.*<\/dt>|<dd>.*<\/dd>/';
        preg_match_all($listNumberStr, $data, $list);
        $tag = array();
        foreach ($list[0] as $key => &$value) {
        	if($key >= 20){
        		continue;
        	}
        	$ss[] = strip_tags($value);
        }
        $arr = array_chunk($ss, 2);

        $this->csvFile($arr);
    }
	
		
	3.通过fputcsv函数将拿到的数组数据遍历到csv的文件中

	protected function csvFile($sales,$bool = true)
    {
        // 打开文件句柄
        $fh = @fopen('ibosFile.csv', 'w+') or die("Can't open ibosFile.csv");
        // 循环遍历
        $aucom = array('authorization date' , 'company name');
        foreach ($sales as $sales_line) {
            if (fputcsv($fh, $sales_line) === false) {
            	$bool = false;
                die("Can't write CSV line");
            }
        }
        if($bool){
	        echo 'csv文件生成成功';
        }else{
        	echo 'csv文件上传失败';
        }
        // 关闭句柄
        fclose($fh) or die("Can't close file.csv");
    }


	4.使用:调用我的csv.class.php类,把csv文件夹放到服务器上,
       访问该文件夹即可,生成扒取的内容文件
	