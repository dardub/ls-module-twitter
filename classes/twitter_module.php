<?

	define('PATH_MOD_TWITTER', realpath(dirname(__FILE__) . '/../'));

	class Twitter_Module extends Core_ModuleBase {
		protected function createModuleInfo() {
			return new Core_ModuleInfo(
				"Twitter",
				"Provides basic integration with Twitter for your store.",
				"Limewheel Creative Inc."
			);
		}
	}