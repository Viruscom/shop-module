<?php

return [
    'shop'   => [
        'index'          => 'Магазин',
        'create'         => 'Добавяне на',
        'edit'           => 'Редактиране на ',
        'settings_index' => 'Магазин настройки',
        'dashboard'      => 'Табло',
    ],
    'common' => [
        'number'  => '№',
        'type'    => 'Тип',
        'title'   => 'Заглавие',
        'actions' => 'Действия'
    ],

    'products' => [
        'index'                                      => 'Продукти',
        'create'                                     => 'Добавяне на продукт',
        'edit'                                       => 'Редактиране на продукт',
        'no_records'                                 => 'Няма намерени продукти',
        'sku_number'                                 => 'SKU',
        'barcode'                                    => 'Баркод',
        'units_in_stock'                             => 'Наличност',
        'weight'                                     => 'Тегло (кг)',
        'width'                                      => 'Широчина (см)',
        'height'                                     => 'Височина (см)',
        'length'                                     => 'Дължина (см)',
        'brand'                                      => 'Марка',
        'supplier_delivery_price'                    => 'Доставна Цена без ДДС',
        'price'                                      => 'Цена без ДДС',
        'attach_to_category'                         => 'Прикрепи към Категория',
        'make_product_adbox'                         => 'Създай продуктово каре',
        'create_not_allowed_add_product_category'    => '<strong>Внимание!</strong> Първо трябва да добавите продуктова категория и марка. След това ще можете да добавите продукт.',
        'additional_fields'                          => 'Допълнителни полета',
        'additional_field_title'                     => 'Заглавие на поле',
        'additional_field_value'                     => 'Стойност на поле',
        'label_new_product'                          => 'Нов продукт',
        'label_promo_product'                        => 'Промо продукт',
        'weight_regex'                               => 'Полето за тегло трябва да е от типа 0.00',
        'weight_min'                                 => 'Полето за тегло трябва да е минимум 0.01',
        'weight_max'                                 => 'Полето за тегло трябва да е максимум 99999.99',
        'width_regex'                                => 'Полето за широчина трябва да е от типа 0.00',
        'width_min'                                  => 'Полето за широчина трябва да е минимум 0.01',
        'width_max'                                  => 'Полето за широчина трябва да е максимум 99999.99',
        'height_regex'                               => 'Полето за височина трябва да е от типа 0.00',
        'height_min'                                 => 'Полето за височина трябва да е минимум 0.01',
        'height_max'                                 => 'Полето за височина трябва да е максимум 99999.99',
        'length_regex'                               => 'Полето за дължина трябва да е от типа 0.00',
        'length_min'                                 => 'Полето за дължина трябва да е минимум 0.01',
        'length_max'                                 => 'Полето за дължина трябва да е максимум 99999.99',
        'price_greater_than_supplier_delivery_price' => 'Цената трябва да е по-голяма от цената за доставка на доставчика.',
    ],

    'product_adboxes' => [
        'index'                         => 'Продуктови карета',
        'create'                        => 'Добавяне на каре',
        'edit'                          => 'Редактиране на каре',
        'type_0'                        => 'Изчакващо',
        'type_1'                        => 'Тип 1',
        'no_records'                    => 'Няма намерени продуктови карета',
        'waiting_action'                => 'Продуктови карета очакващи действие',
        'product_ad_box_already_exists' => 'Продуктовото каре вече съществува'
    ],

    'product_categories' => [
        'index'      => 'Категории',
        'create'     => 'Добавяне на категория',
        'edit'       => 'Редактиране на категория',
        'no_records' => 'Няма намерени продуктови категории',
    ],

    'product_brands' => [
        'index'      => 'Марки',
        'create'     => 'Добавяне на марка',
        'edit'       => 'Редактиране на марка',
        'no_records' => 'Няма намерени марки',
    ],

    'product_attributes' => [
        'index' => 'Атрибути',
    ],

    'product_characteristics' => [
        'index' => 'Характеристики',
    ],

    'product_combinations' => [
        'index' => 'Комбинации',
    ],

    'product_collections' => [
        'index' => 'Колекции',
    ],

    'product_stocks' => [
        'index' => 'Наличности',
    ],

    'abandoned_baskets' => [
        'index' => 'Изоставени колички',
    ],

    'orders' => [
        'index'           => 'Поръчки',
        'no_orders_found' => 'Няма намерени поръчки',
    ],

    'returned_products' => [
        'index' => 'Върнати продукти',
    ],

    'product_gifts' => [
        'index' => 'Подаръци',
    ],

    'registered_users' => [
        'index'         => 'Рег. потребители',
        'full_name'     => 'Име и фамилия',
        'email'         => 'Имейл',
        'registered_at' => 'Регистриран на',
    ],

    'h18_reports' => [
        'index' => 'Н-18 отчети',
    ],

    'discounts' => [
        'index'                    => 'Отстъпки',
        'edit'                     => 'Редактиране на отстъпка',
        'no-discounts'             => 'Няма добавени отстъпки',
        'client_group'             => 'Клиентска група',
        'client_group_1'           => 'Клиентска група 1',
        'client_group_2'           => 'Клиентска група 2',
        'client_group_3'           => 'Клиентска група 3',
        'client_group_4'           => 'Клиентска група 4',
        'client_group_5'           => 'Клиентска група 5',
        'client_group_6'           => 'Клиентска група 6',
        'name'                     => 'Име на отстъпката',
        'type'                     => 'Тип',
        'created_at'               => 'Създадена на',
        'type_fixed_amount'        => 'Тип фиксирана стойност',
        'type_fixed_percent'       => 'Тип фиксиран процент',
        'type_fixed_free_delivery' => 'Тип безплатна доставка',
        'type_quantity'            => 'Тип количествена',
        'type_bonus_on_item'       => 'Тип бонус върху продукт',
        'applies_to'               => 'Приложи към',
        'applies_to_1'             => 'Приложи към всеки продукт',
        'applies_to_2'             => 'Приложи към марка',
        'applies_to_3'             => 'Приложи към категория продукти',
        'applies_to_4'             => 'Приложи към определен продукт',
        'applies_to_5'             => 'Приложи към поръчки над стойност',
        'valid_from'               => 'Валидна от',
        'valid_to'                 => 'Валидна до',
        'promo_code'               => 'Промо код',
        'max_uses'                 => 'Максимално пъти за използване',
        'amount'                   => 'Стойност',
        'choose_product'           => 'Изберете продукт',
        'choose_brand'             => 'Изберете марка',
        'choose_categories'        => 'Изберете категории',
        'order_amount'             => 'Стойност на поръчката',
<<<<<<< HEAD
        'from_quantity'            => 'От количество',
        'to_quantity'              => 'До количество',
        'quantity_price'           => 'Цена',
        'for_product'              => 'За продукт',
=======
>>>>>>> origin/main
    ],

    'shop_settings' => [
        'index' => 'Магазин настройки',
    ],

    'main_settings' => [
        'warning' => '<strong>Внимание!</strong><br><span>Всяко действие в настройките може да доведе до каскадни промени. Ако сте обучен за работа с тази част от магазина, моля, продължете.</span>',
        'index'   => 'Основни настройки'
    ],

    'payments' => [
        'index'          => 'Плащания',
        'position'       => 'Позиция',
        'payment_system' => 'Разплащателна система',
        'status'         => 'Статус',
        'no-payments'    => 'Няма добавени разплащателни системи',
    ],

    'deliveries' => [
        'index' => 'Доставки',
    ],

    'post_codes' => [
        'index' => 'Пощенски кодове',
    ],

    'vats' => [
        'index' => 'ДДС ставки',
    ],
];
