<?php

/**
 * @author Bastien Sevajol (bastien.sevajol@xsalto.com)
 * 
 * Cette classe permet de transformer des données seolan dans une forme plus 
 * exploitable (voir doc de ->getFormatedData())
 */
class DataOrganizer {
  
  /**
   * 
   * @param array $non_formated_data du type:
   * array(
   *   'olines_oid'   => array(
   *     0 => '1',
   *     0 => '2'
   *   ),
   *   'olines_oname'  => array(
   *     0 => 'Jean',
   *     0 => 'Paul'
   *   ),
   *   'olines_ophone' => array(
   *     0 => '0676548382',
   *     0 => '0676548383'
   *   ),
   * )
   * @return array of data transformé en:
   * array(
   *   array(
   *     'oid'    => '1',
   *     'oname   => 'Jean',
   *     'ophone' => '0676548382'
   *   ),
   *   array(
   *     'oid'    => '2',
   *     'oname   => 'Paul',
   *     'ophone' => '0676548383'
   *   )
   * )
   */
  public function getFormatedData($non_formated_data) {
    $formated_data = array();
    
    foreach (array_keys($non_formated_data) as $non_formated_data_line_key) {
      if (strpos($non_formated_data_line_key, 'lines_') !== False) {
        $formated_data = $this->getUpdatedFormatedDataForField($formated_data, $non_formated_data, $non_formated_data_line_key);
      }
    }
    
    return $formated_data;
  }
  
  protected function getUpdatedFormatedDataForField($formated_data, $non_formated_data, $non_formated_data_line_key) {
    foreach ($non_formated_data[$non_formated_data_line_key] as $key => $field) {
      $formated_data = $this->updateFormatedDataWithField($formated_data, str_replace('lines_', '', $non_formated_data_line_key), $key, $field);
    }
    
    return $formated_data;
  }
  
  protected function updateFormatedDataWithField($data, $field_id, $key, $field) {    
    if (!array_key_exists($key, $data)) {
      $data[$key] = array();
    }
    $data[$key] = array_merge($data[$key], array($field_id => $field));
    
    return $data;
  }
  
}