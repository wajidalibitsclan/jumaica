<?php
	namespace Themes\GoTrip\Core\Walkers;
	class MenuWalker
	{
		protected static $currentMenuItem;
		protected        $menu;
		protected        $options;
		protected $activeItems = [];

		public function __construct($menu)
		{
			$this->menu = $menu;
		}

		public function generate($options = [])
		{
		    $this->options = $options ?? [];
			$items = json_decode($this->menu->items, true);
			$custom_class = (!empty($this->options)) ? $this->options['custom_class'] : null;
			if (!empty($items)) {
				echo "<ul class='menu__nav {$custom_class} -is-active'>";
				$this->generateTree($items);
				echo '</ul>';
			}
		}

		public function generateTree($items = [],$depth = 0,$parentKey = '')
		{
            $desktopMenu = $this->options['desktop_menu'] ?? false;

			foreach ($items as $k=>$item) {

				$class = e($item['class'] ?? '');
				$url = $item['url'] ?? '';
				$item['target'] = $item['target'] ?? '';
				if (!isset($item['item_model']))
					continue;
				if (class_exists($item['item_model'])) {
					$itemClass = $item['item_model'];
					$itemObj = $itemClass::find($item['id']);
					if (empty($itemObj)) {
						continue;
					}
					$url = $itemObj->getDetailUrl();
				}
				if ($this->checkCurrentMenu($item, $url))
				{
					$class .= ' active';
					$this->activeItems[] = $parentKey;
				}

				if (!empty($item['children'])) {
					ob_start();
					$this->generateTree($item['children'],$depth + 1,$parentKey.'_'.$k);
					$html = ob_get_clean();
					if(in_array($parentKey.'_'.$k,$this->activeItems)){
						$class.=' active ';
					}
				}
				$class.= ($depth == 0 && !empty($item['children'])) ? 'menu-item-has-children' : null;
				$class.=' depth-'.($depth);
				printf('<li class="%s">', $class);
                $itemName = $item['name'];
                if (!empty($item['children'])) {
                    $item['name'] = "<span class='mr-10'>{$item['name']}</span><i class='icon icon-chevron-sm-down'></i>";
                }
                printf('<a '.($desktopMenu ? 'data-barba' : '').' target="%s" href="%s" >%s</a>', e($item['target']), e($url), clean($item['name']));
                if (!empty($item['children'])) {
                    echo '<ul class="subnav">';
                    if($desktopMenu){
                        echo '<li class="subnav__backBtn js-nav-list-back">
                                <a href="#"><i class="icon icon-chevron-sm-down"></i> '.$itemName.'</a>
                            </li>';
                    }
                    echo $html;
                    echo "</ul>";
                }
				echo '</li>';
			}
		}

		protected function checkCurrentMenu($item, $url = '')
		{

			if(trim($url,'/') == request()->path()){
				return true;
			}
			if (!static::$currentMenuItem)
				return false;
			if (empty($item['item_model']))
				return false;
			if (is_string(static::$currentMenuItem) and ($url == static::$currentMenuItem or $url == url(static::$currentMenuItem))) {
				return true;
			}
			if (is_object(static::$currentMenuItem) and get_class(static::$currentMenuItem) == $item['item_model'] && static::$currentMenuItem->id == $item['id']) {
				return true;
			}
			return false;
		}

		public static function setCurrentMenuItem($item)
		{
			static::$currentMenuItem = $item;
		}

		public static function getActiveMenu()
		{
			return static::$currentMenuItem;
		}
	}
