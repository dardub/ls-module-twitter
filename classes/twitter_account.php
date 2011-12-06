<?

	class Twitter_Account {
		public $options;
	
		public function __construct($options = array()) {
			$this->options = array_merge(array(
				'username' => null
			), $options);
		}
		
		public static function create($options = array()) {
			return new Twitter_Account($options);
		}
		
		public static function ago($timestamp){
	    	return date("m.d.y", $timestamp);
	    }
	
	
		public function get_tweets($options = array()) {
			extract(array_merge(array(
				'count' => 50,
				'format' => 'json'
			), $this->options, $options));
			
			$items = json_decode(file_get_contents("http://api.twitter.com/1/statuses/user_timeline.{$format}?id={$username}&count={$count}&page=1&include_rts=true&include_entities=true")); // get tweets and decode them into a variable
			$tweets = array();
			
			foreach(array_slice($items, 0, $count) as $item):
			  $time = self::ago(strtotime($item->created_at));
			  
			  $tweets[] = array('content' => isset($item->retweeted_status) ? 'RT @' . $item->retweeted_status->user->screen_name . ': ' . $item->retweeted_status->text : $item->text, 'date' => $time);
			endforeach;

			return $tweets;
		}
	}