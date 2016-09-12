<?php
  $Shop_Controller_Show = new Shop_Controller_Show(
	 Core_Entity::factory('shop', 1)
  );
  $Shop_Controller_Show
	 ->xsl(
		Core_Entity::factory('Xsl')->getByName('МагазинКаталогТоваровНаГлавнойСпец')
	 )
	->itemsProperties(TRUE)
	 ->groupsMode('none')
	 ->itemsForbiddenTags(array('text'))
	 ->group(FALSE)
	 ->limit(4)
	 //->show()
	 ;

  // Объединение с нужной таблицей свойств
  $Shop_Controller_Show
	 ->shopItems()
	 ->queryBuilder()
	 ->leftJoin('shop_item_properties', 'shop_items.shop_id', '=', 'shop_item_properties.shop_id')
	 ->leftJoin('property_value_ints', 'shop_items.id', '=', 'property_value_ints.entity_id',
		array(
		   array('AND' => array('shop_item_properties.property_id', '=', Core_QueryBuilder::expression('`property_value_ints`.`property_id`')))
		)
	 )
	 // Идентификатор дополнительного свойства
	 ->where('shop_item_properties.property_id', '=', 60)
	 // Значание дополнительного свойства
	 ->where('property_value_ints.value', '=', '1')
	 ->groupBy('shop_items.id')
	 // Количество свойств
	 ->having('COUNT(shop_item_properties.shop_id)', '=', 1)
	 ;

	 $Shop_Controller_Show->show();
?>