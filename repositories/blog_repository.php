<?php
// include_once 'repositories/main_repository.php';
global $app;
class blog_repository extends main_repository {

	public function getLike($id) {
        $likeModel = like_model::getInstance();
		$record = $likeModel->getLikeRecord($id, "*", "type = 'comment'");
		$liked = array();
		foreach ($record as $parentArray) {
			foreach ($parentArray as $k=>$v) {
				// array_push($liked, $v);
				$liked[]=$v;
			}
		}
		return $liked;
	}
}