<?php

class MenuOrganizer {
  
  protected $original_menu_data;
  
  public function __construct($menu_data) {
    $this->original_menu_data = $menu_data;
  }
  
  public function getOrganized() {
    $organized_menu = array();
    foreach ($this->original_menu_data as $menu_element) {
      if ($menu_element['level'] == 1) {
        $organized_menu[] = $this->getMenuWithHisChilds($menu_element);
      }
    }
    
    return $organized_menu;
  }
  
  protected function getMenuWithHisChilds($menu_element) {
    $menu_element['childs'] = $this->getMenuChilds($menu_element['oid']);
    return $menu_element;
  }
    
  protected function getMenuChilds($parent_menu_id) {
    $menu_childs = array();
    foreach ($this->original_menu_data as $menu_element) {
      if ($menu_element['olinkup']->raw == $parent_menu_id) {
        $menu_childs[] = $this->getMenuWithHisChilds($menu_element);
      }
    }
    
    return $menu_childs;
  }
  
}