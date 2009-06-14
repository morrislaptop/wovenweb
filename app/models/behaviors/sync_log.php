<?php
class SyncLogBehavior extends ModelBehavior
{
	function beforeSave($model) {
		if ( !empty($model->data[$model->alias]['app1data']) && !is_string($model->data[$model->alias]['app1data']) ) {
			$model->data[$model->alias]['app1data'] = serialize($model->data[$model->alias]['app1data']);
		}
		if ( !empty($model->data[$model->alias]['app2data']) && !is_string($model->data[$model->alias]['app2data']) ) {
			$model->data[$model->alias]['app2data'] = serialize($model->data[$model->alias]['app2data']);
		}
		return parent::beforeSave($model);
	}
	
	function afterFind($model, $results) {
		foreach ($results as &$result) {
			if ( !empty($result[$model->alias]['app1data']) ) {
				$result[$model->alias]['app1data'] = unserialize($result[$model->alias]['app1data']);
			}
			if ( !empty($result[$model->alias]['app2data']) ) {
				$result[$model->alias]['app2data'] = unserialize($result[$model->alias]['app2data']);
			}
		}
		return $results;
	}
}
?>