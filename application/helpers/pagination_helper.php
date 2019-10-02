<?php
class Pagination_helper
{
	private static $__instance;
	public static function getInstance() {
		if (! self::$__instance) {

			self::$__instance = new Pagination_helper();
		}
		return self::$__instance;
	}
	public function create($page , $url , $totalObjectIds ,$div , $spinnerPath,$spinnerId,$limit=10){	

 



		$pagination = '<div class="pagination"><div class="pagination_inner"><a style="display: none;" id="'.$spinnerId.'" class="pagination_bns_prev"><img title="Loading page" src="'.$spinnerPath.'"></a>';
	 	$limitvalue = ($page - 1) * $limit;	
		
		if($page > 1){
			$pageprev = $page-1;
		
			if(strstr($url,'?')){

				$url1=$url.'&page='.$pageprev;
			}else{
				$url1=$url.'?page='.$pageprev;
			}
			
			$pagination .= '<a title="Previous"  class="pagination_bns_prev" href="#" onclick="simpleAjaxPaging(\''.$url1.'\',\''.$div.'\',\''.$spinnerId.'\');return false;">Previous</a>&nbsp;';
		}
		else
		{
			//$pagination .= '<a title="No Page">Previous</a>';
		}	
			                                                            
		$numofpages = ceil($totalObjectIds / $limit);
	
		for($i = 1; $i <= $numofpages; $i++)
		{
			//if($i > $page-10 and $i < $page+10)
			if($i > $page-3 and $i < $page+3)
			{
				if($page == $i){
					$pagination .= '<a title="Page '.$i.'"  class="active" href="#" >'.$i.'</a>'.'&nbsp;';
				}else{
					
					
					if(strstr($url,'?')){
						$url1=$url.'&page='.$i;
					}else{
						$url1=$url.'?page='.$i;
					}	
					
					$pagination .= '<a title="Page '.$i.'" href="#" class="pagination_bns" onclick="simpleAjaxPaging(\''.$url1.'\',\''.$div.'\',\''.$spinnerId.'\');return false;">'.$i.'</a>&nbsp;';
				}
			}
		}			

		if($page < $numofpages)
		{
			$pagenext = ($page + 1);
			$url1=$url.'?page='.$pagenext;
			if(strstr($url,'?')){
				$url1=$url.'&page='.$pagenext;
			}else{
				$url1=$url.'?page='.$pagenext;
			}
			$pagination .= '&nbsp;<a title="Next" href="#"  class="pagination_bns_prev" onclick="simpleAjaxPaging(\''.$url1.'\',\''.$div.'\',\''.$spinnerId.'\');return false;">Next</a>';
		}		
		else{
			//$pagination .= '&nbsp;<a title="No Page" style="color:#888;">Next</a>';
		}
		$pagination .='</div></div>';
		$starting = ($totalObjectIds > 0) ? $limitvalue+1 : 0;
	 	$ending = $limitvalue+$limit;
	 	$pagingData = array();
	 	$pagingData['html'] = $pagination;
	 	$pagingData['starting'] = $starting;
	 	$pagingData['ending'] = $ending;
	 	$pagingData['limitvalue'] = $limitvalue;
	 	$pagingData['limit'] = $limit;
	 	return $pagingData;
	}
	
	
}
?>