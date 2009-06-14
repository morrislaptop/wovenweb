<?php
class RefreshShell extends Shell
{
	function main()
	{
		$this->out("Running WovenWeb Refresh");
		
		// Append to $this->uses the model for all installed plugins.
		$pluginPaths = Configure::read('pluginPaths');
		if (!class_exists('Folder')) {
			require LIBS . 'folder.php';
		}
		foreach ($pluginPaths as $pluginPath) {
			$Folder =& new Folder($pluginPath);
			list($plugins,) = $Folder->read(false, true);
			foreach ((array)$plugins as $plugin) {
				$path = $pluginPath . Inflector::underscore($plugin) . DS . 'models' . DS . Inflector::underscore($plugin) . '_log.php';
				if (file_exists($path)) {
					$className = Inflector::camelize($plugin) . '.' . Inflector::camelize($plugin . '_log');
					$this->uses[] = $className;
				}
			}
		}
		
		// Init all the models then call the sync method on each.
		$this->_loadModels();
		foreach ($this->uses as $model) {
			$modelClassName = $model;
			if (strpos($model, '.') !== false) {
				list($plugin, $modelClassName) = explode('.', $model);
			}
			if ( method_exists($this->$modelClassName, 'refresh') ) {
				$this->out('Calling ' . $modelClassName . '->refresh()');
				$this->$modelClassName->refresh();
			}
		}
	}
}
?>