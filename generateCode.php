<?php
	include("islogin.php");
	include("common.php");

	$time = date("Y-m",time());
	$sql = "select im_id from camera where create_timestamp like '$time%'";
	$stmt = $dbh -> query($sql);
	$row = $stmt -> fetchAll(PDO::FETCH_ASSOC);
	$ary=array();
	foreach($row as $k=>$v)
	{
		$ary[]=$v['im_id'];
	}

	$year  = substr(date('Ym'), 2,4);

	$rand = $year.rand(1000,9999);
	$t = isary($rand,$ary);
	while($t==1)
	{
		$rand = $year.rand(1000,9999);
		$t = isary($rand,$ary);
	}
	echo json_encode($rand);
	exit;
	
	function isary($rand,$ary)
	{
		if (in_array($rand,$ary))
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	// $school = $_GET['school'];

	// $sql = "select im_id from camera where school_id='".$school."' order by create_timestamp desc";
	/*$sql = "select im_id from camera order by create_timestamp desc";
	$stmt = $dbh -> query($sql);
	$row = $stmt -> fetch();

	$now   = date('Y-m-d');
	$year  = substr($now, 2,2);
	$month = substr($now, 5,2);
	$day   = substr($now, 8,2);

	if($row){
                $old = $row['im_id'];
                $old_y = substr($old, 0,2);
                $old_m = substr($old, 2,2);
                $old_d = substr($old, 4,2);
                $index = substr($old, 6,2);

                if($old_y==$year&&$old_m==$month&&$old_d==$day){
                        $i = ord(substr($index, 0,1));
                        $k = ord(substr($index, 1,1));

                        switch ($k) {
                                case 57:
                                        $index = chr($i).'A';
                                        break;
                                case 90:
                                        $index = chr($i).'a';
                                        break;
                                case 122:
                                        switch ($i) {
                                                case 57:
                                                        $index = 'A0';
                                                        break;
                                                case 90:
                                                        $index = 'a0';
                                                        break;
                                                case 122:
                                                        $index = '00';
                                                        break;
                                                default:
                                                        $index = chr($i+1).'0';
                                                        break;
                                        }
                                        break;
                                default:
                                        $index = chr($i).chr($k+1);
                                        break;
                        }

                }else{
                        $index = '00';
                }
        }else{
                $index = '00';
        }


	$code = $year.$month.$day.$index;

	echo json_encode($code);*/
?>