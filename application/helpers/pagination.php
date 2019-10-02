<?php

class Pagination

{

	private static $__instance;

	public static function getInstance() {

		if (! self::$__instance) {



			self::$__instance = new PageCreator();

		}

		return self::$__instance;

	}

	public function create($page , $url , $totalObjectIds ,$div , $spinnerPath,$spinnerId,$limit=10){	

		$onClick1 = 'onclick="simpleAjax(\'';

		$onClick2 = '\',\''.$reFresh.'\',\'\',\''.$spinner.'\',0); return false;"';

		$pagination = '<ul class="paginations-blue" style="float:right"><li style="display: none;" id="'.$spinner.'" ><img title="Loading page" src="'.$spinnerPath.'"></li><li>';

	 	$limitvalue = ($page - 1) * $limit;	

		if($page > 1){

			$pageprev = $page-1;

			$url1='?page='.$pageprev;

			$pagination .= '<a title="Previous" onclick="simpleAjaxPaging(\''.$url1.'\',\''.$div.'\',\''.$spinnerId.'\');">Previous</a>&nbsp;';

		}

		else

		{

			$pagination .= '<a title="No Page">Previous</a>';

		}	

			                                                            

		$numofpages = ceil($totalObjectIds / $limit);

	

		for($i = 1; $i <= $numofpages; $i++)

		{

			if($i > $page-10 and $i < $page+10)

			{

				if($page == $i){

					$pagination .= '<a title="Page '.$i.'" class="active" >'.$i.'</a>'.'&nbsp;';

				}else{

					$url1='?page='.$page;

					$pagination .= '<a title="Page '.$i.'" onclick="simpleAjaxPaging(\''.$url1.'\',\''.$div.'\',\''.$spinnerId.'\');"">'.$i.'</a>&nbsp;';

				}

			}

		}			



		if($page < $numofpages)

		{

			$pagenext = ($page + 1);

			$url1='?page='.$pagenext;

			$pagination .= '&nbsp;<a title="Next"  onclick="simpleAjaxPaging(\''.$url1.'\',\''.$div.'\',\''.$spinnerId.'\');">Next</a>';

		}		

		else{

			$pagination .= '&nbsp;<a title="No Page" style="color:#888;">Next</a>';

		}

		$pagination .= '</li>

		</ul>';

		

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