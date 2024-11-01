<?php

/**
 * _USER_TECHNICAL_AGREEMENT
 * 
 * @category  ups-shipping-for-woocommerce
 * @package   UPS Shipping and UPS Access Point™ : Official Plugin For WooCommerce
 * @author    United Parcel Service of America, Inc. <noreply@ups.com>
 * @license   This work is Licensed under the Apache License, version 2.0
 * https://www.apache.org/licenses/LICENSE-2.0
 * @copyright (c) 2019, United Parcel Service of America, Inc., all rights reserved
 * @link      https://www.ups.com/pl/en/services/technology-integration/ecommerce-plugins.page
 * 
 * _LICENSE_TAG
 *
 * Shipment.php - The core plugin class.
 * 
 * This is used to create shipment, get tracking, print label shipment and cancel shipment.
 */

class Ups_Eu_Woo_Shipment
{    
    const COUNTRY_EU = [
        "Austria" => "AT",
        "Belgium" => "BE",
        "Bulgaria" => "BG",
        "Croatia" => "HR",
        "Cyprus" => "CY",
        "CzechRepublic" => "CZ",
        "Denmark" => "DK",
        "Estonia" => "EE",
        "Finland" => "FI",
        "France" => "FR",
        "Germany" => "DE",
        "Greece" => "GR",
        "Hungary" => "HU",
        "Ireland" => "IE",
        "Italy" => "IT",
        "Latvia" => "LV",
        "Lithuania" => "LT",
        "Luxembourg" => "LU",
        "Malta" => "MT",
        "Netherlands" => "NL",
        "Poland" => "PL",
        "Portugal" => "PT",
        "Romania" => "RO",
        "Slovakia" => "SK",
        "Slovenia" => "SI",
        "Spain" => "ES",
        "Sweden" => "SE",
        "UnitedKingdom" => "GB",
    ];
    const EIGHTEUCOUNTRY = ['BE', 'NL', 'FR', 'ES', 'PL', 'IT', 'DE', 'UK'];

	private $_DimensionsData = 'Dimensions';
	private $_UnitOfMeasurementData = 'UnitOfMeasurement';
	private $_DescriptionData = 'Description';
	private $_PackageWeightData = 'PackageWeight';
	private $_accessorialsData = 'accessorials';
	private $_CurrencyCodeData = 'CurrencyCode';
	private $_char_num_Data = '([^a-zA-Z0-9.])';
	private $_MonetaryValueData = 'MonetaryValue';
	private $_RequestData = 'Request';
	private $_RequestOptionData = 'RequestOption';
	private $_ShipperData = 'Shipper';
	private $_AttentionNameData = 'AttentionName';
	private $_PhoneData = 'Phone';
	private $_NumberData = 'Number';
	private $_AddressData = 'Address';
	private $_AddressLineData = 'AddressLine';
	private $_StateProvinceCodeData = 'StateProvinceCode';
	private $_PostalCodeData = 'PostalCode';
	private $_CountryCodeData = 'CountryCode';
	private $_ShipToData = 'ShipTo';
	private $_ShipFromData = 'ShipFrom';
	private $_ServiceData = 'Service';
	private $_PaymentInformationData = 'PaymentInformation';
	private $_ShipmentChargeData = 'ShipmentCharge';
	private $_BillShipperData = 'BillShipper';
	private $_AccountNumberData = 'AccountNumber';
	private $_EmailData = 'Email';
	private $_AlternateDeliveryAddressData = 'AlternateDeliveryAddress';
	private $_UnitOfMeasurement = "UnitOfMeasurement";
	private $_Description = "Description";
	private $_CurrencyCode = "CurrencyCode";
	private $_MonetaryValue = "MonetaryValue";
	private $_Shipment = "Shipment";
	private $_Address = "Address";
	private $_NotificationCode = "NotificationCode";
	private $_EMail = "EMail";
	private $_EMailAddress = "EMailAddress";
	private $_Locale = "Locale";
	private $_Language = "Language";
	private $_Dialect = "Dialect";
	private $_ShipmentServiceOptions = "ShipmentServiceOptions";

    public function ups_eu_woo_shipment_create_shipments($data, $upsSecurity) {
        //add ups security.
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->ShipmentRequest = [];
        $Package = [];
        $Notification = []; 
        foreach ($data['Package'] as $key => $value) {
            $Package[$key] = [
                "Dimensions" => [
                    $this->_UnitOfMeasurement => [
                        "Code" => strtoupper($value[$this->_DimensionsData][$this->_UnitOfMeasurementData]['Code']),
                        $this->_Description => $value[$this->_DimensionsData][$this->_UnitOfMeasurementData]
                            [$this->_DescriptionData]
                    ],
                    "Length" => $value[$this->_DimensionsData]['Length'],
                    "Width" => $value[$this->_DimensionsData]['Width'],
                    "Height" => $value[$this->_DimensionsData]['Height']
                ],
                "PackageWeight" => [
                    $this->_UnitOfMeasurement => [
                        "Code" => strtoupper($value[$this->_PackageWeightData][$this->_UnitOfMeasurementData]['Code']),
                        $this->_Description => $value[$this->_PackageWeightData][$this->_UnitOfMeasurementData]
                            [$this->_DescriptionData]
                    ],
                    "Weight" => $value[$this->_PackageWeightData]['Weight']
                ],
                'Packaging' => [
                    'Code' => '02'
                ],
                'PackagingType' => [
                    'Code' => '02'
                ],
                'PackageServiceOptions' => []
            ];
            if (isset($data[$this->_accessorialsData]) && array_key_exists('UPS_ACSRL_ADDITIONAL_HADING', 
                $data[$this->_accessorialsData])) {
                $Package[$key]["AdditionalHandlingIndicator"] = "";
            }
            if (isset($data[$this->_accessorialsData]) && array_key_exists('UPS_ACSRL_DECLARED_VALUE', 
                $data[$this->_accessorialsData])) {
                $Package[$key]["PackageServiceOptions"] = [
                    "DeclaredValue" => [
                        "Type" => [
                            "Code" => "01",
                            "Descripton" => "EVS"
                        ],
                        $this->_CurrencyCode => $data[$this->_CurrencyCodeData],
                        $this->_MonetaryValue => preg_replace($this->_char_num_Data, '', 
                            (string)$data[$this->_MonetaryValueData])
                    ]
                ];
            }
        }
        $request->ShipmentRequest = [
            $this->_RequestData => [
                $this->_RequestOptionData =>  'validate',
                'SubVersion' => '1801'
            ],
            'Shipment' => [
                $this->_DescriptionData => $this->_DescriptionData,
                $this->_ShipperData => [
                    'Name' => $data[$this->_ShipperData]['Name'],
                    $this->_AttentionNameData => $data[$this->_ShipperData][$this->_AttentionNameData],
                    'ShipperNumber' => $data[$this->_ShipperData]['ShipperNumber'],
                    $this->_PhoneData => [
                        $this->_NumberData => $data[$this->_ShipperData][$this->_PhoneData][$this->_NumberData]
                    ],
                    $this->_AddressData => [
                        $this->_AddressLineData => [
                            $data[$this->_ShipperData][$this->_AddressData][$this->_AddressLineData][0],
                            $data[$this->_ShipperData][$this->_AddressData][$this->_AddressLineData][1],
                            $data[$this->_ShipperData][$this->_AddressData][$this->_AddressLineData][2]
                        ],
                        'City' => $data[$this->_ShipperData][$this->_AddressData]['City'],
                        $this->_StateProvinceCodeData => 
                            $data[$this->_ShipperData][$this->_AddressData][$this->_StateProvinceCodeData],
                        $this->_PostalCodeData => 
                            $data[$this->_ShipperData][$this->_AddressData][$this->_PostalCodeData],
                        $this->_CountryCodeData => 
                            $data[$this->_ShipperData][$this->_AddressData][$this->_CountryCodeData]
                    ]
                ],
                $this->_ShipToData => [
                    'Name' => $data[$this->_ShipToData]['Name'],
                    $this->_AttentionNameData => $data[$this->_ShipToData][$this->_AttentionNameData],
                    $this->_PhoneData => [
                        $this->_NumberData => $data[$this->_ShipToData][$this->_PhoneData][$this->_NumberData]
                    ],
                    $this->_AddressData => [
                        $this->_AddressLineData => [
                            $data[$this->_ShipToData][$this->_AddressData][$this->_AddressLineData][0],
                            $data[$this->_ShipToData][$this->_AddressData][$this->_AddressLineData][1],
                            $data[$this->_ShipToData][$this->_AddressData][$this->_AddressLineData][2]
                        ],
                        'City' => $data[$this->_ShipToData][$this->_AddressData]['City'],
                        $this->_StateProvinceCodeData => 
                            $data[$this->_ShipToData][$this->_AddressData][$this->_StateProvinceCodeData],
                        $this->_PostalCodeData => 
                            $data[$this->_ShipToData][$this->_AddressData][$this->_PostalCodeData],
                        $this->_CountryCodeData => 
                            $data[$this->_ShipToData][$this->_AddressData][$this->_CountryCodeData]
                    ]
                ],
                $this->_ShipFromData => [
                    'Name' => $data[$this->_ShipFromData]['Name'],
                    $this->_PhoneData => [
                        $this->_NumberData => $data[$this->_ShipFromData][$this->_PhoneData][$this->_NumberData]
                    ],
                    $this->_AddressData => [
                        $this->_AddressLineData => [
                            $data[$this->_ShipFromData][$this->_AddressData][$this->_AddressLineData][0],
                            $data[$this->_ShipFromData][$this->_AddressData][$this->_AddressLineData][1],
                            $data[$this->_ShipFromData][$this->_AddressData][$this->_AddressLineData][2]
                        ],
                        'City' => $data[$this->_ShipFromData][$this->_AddressData]['City'],
                        $this->_StateProvinceCodeData => 
                            $data[$this->_ShipFromData][$this->_AddressData][$this->_StateProvinceCodeData],
                        $this->_PostalCodeData => 
                            $data[$this->_ShipFromData][$this->_AddressData][$this->_PostalCodeData],
                        $this->_CountryCodeData => 
                            $data[$this->_ShipFromData][$this->_AddressData][$this->_CountryCodeData]
                    ]
                ],
                $this->_ServiceData => [
                    'Code' => $data[$this->_ServiceData]['Code'],
                    $this->_DescriptionData => $data[$this->_ServiceData][$this->_DescriptionData]
                ],
                $this->_PaymentInformationData => [
                    $this->_ShipmentChargeData => [
                        [
                            'Type' => '01',
                            $this->_BillShipperData => [
                                $this->_AccountNumberData => $data[$this->_PaymentInformationData]
                                [$this->_ShipmentChargeData][$this->_BillShipperData][$this->_AccountNumberData]
                            ]
                        ]
                    ]
                ],
                'LabelSpecification' => [
                    'LabelImageFormat' => [
                        'Code' => 'GIF',
                        $this->_DescriptionData => 'GIF'
                    ],
                    'HTTPUserAgent' => 'Mozilla/4.5'
                ],
                "Package" => $Package
            ]
        ];

        if (!in_array($data[$this->_ShipToData][$this->_AddressData][$this->_CountryCodeData], self::COUNTRY_EU) ||
        isset($data[$this->_AlternateDeliveryAddressData]) && 
        isset($data[$this->_AlternateDeliveryAddressData][$this->_AddressData]) && 
        !in_array($data[$this->_AlternateDeliveryAddressData][$this->_AddressData][$this->_CountryCodeData], 
        self::EIGHTEUCOUNTRY) && $data['ShippingType'] == 'AP' && 
        isset($data[$this->_AlternateDeliveryAddressData]['COD']) && 
        $data[$this->_AlternateDeliveryAddressData]['COD'] == '1') {
            $request->ShipmentRequest[$this->_Shipment]["PaymentInformation"]["ShipmentCharge"][] = [
                'Type' => '02',
                $this->_BillShipperData => [
                    $this->_AccountNumberData => $data[$this->_PaymentInformationData][$this->_ShipmentChargeData]
                        [$this->_BillShipperData][$this->_AccountNumberData]
                ]
            ];
        }

        if(isset($data[$this->_accessorialsData])){
            foreach($data[$this->_accessorialsData] as $key => $value){
                switch (trim($key)){
                    case 'UPS_ACSRL_ADDITIONAL_HADING':
                        break;
                    case 'UPS_ACSRL_QV_SHIP_NOTIF':
                        $Notification[] = [
                            $this->_NotificationCode => "6",
                            $this->_EMail => [
                                $this->_EMailAddress => $data[$this->_ShipToData][$this->_EmailData] // email eshopper
                            ],
                            $this->_Locale => [
                                $this->_Language => "POL",
                                $this->_Dialect => "97"
                            ]
                        ];
                        break;
                    case 'UPS_ACSRL_QV_DLV_NOTIF':
                        $Notification[] = [
                            $this->_NotificationCode => "8",
                            $this->_EMail => [
                                $this->_EMailAddress => $data[$this->_ShipToData][$this->_EmailData] // email eshopper
                            ],
                            $this->_Locale => [
                                $this->_Language => "POL",
                                $this->_Dialect => "97"
                            ]
                        ];
                        break;
                    case 'UPS_ACSRL_RESIDENTIAL_ADDRESS':
                        $request->ShipmentRequest[$this->_Shipment]["ShipTo"][$this->_Address]
                            ["ResidentialAddressIndicator"] = "1";
                        break;
                    case 'UPS_ACSRL_STATURDAY_DELIVERY':
                        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                            ["SaturdayDeliveryIndicator"] = "";
                        break;
                    case 'UPS_ACSRL_CARBON_NEUTRAL':
                        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                            ["UPScarbonneutralIndicator"] = "";
                        break;
                    case 'UPS_ACSRL_DIRECT_DELIVERY_ONLY':
                        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                            ["DirectDeliveryOnlyIndicator"] = "";
                        break;
                    case 'UPS_ACSRL_DECLARED_VALUE':
                        break;
                    case 'UPS_ACSRL_SIGNATURE_REQUIRED':
                        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                            ["DeliveryConfirmation"]["DCISType"] = "1";
                        break;
                    case 'UPS_ACSRL_ADULT_SIG_REQUIRED':
                        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                            ["DeliveryConfirmation"]["DCISType"] = "2";
                        break;
                    case 'UPS_ACSRL_ACCESS_POINT_COD':
                        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                            ["AccessPointCOD"] = [
                            $this->_CurrencyCode => $data[$this->_CurrencyCodeData],
                            $this->_MonetaryValue => preg_replace($this->_char_num_Data, '', 
                                (string)$data[$this->_MonetaryValueData])
                        ];
                        break;
                    case 'UPS_ACSRL_TO_HOME_COD':
                        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]["COD"] = [
                            "CODFundsCode" => '1',
                            "CODAmount" => [
                                $this->_CurrencyCode => $data[$this->_CurrencyCodeData],
                                $this->_MonetaryValue => preg_replace($this->_char_num_Data, '', 
                                    (string)$data[$this->_MonetaryValueData])
                            ]
                        ];
                        break;                    
                    default:
                        break;
                }
            }
        }
        if($data['ShippingType'] == 'AP'){
            $Notification[] = [
                $this->_NotificationCode => "012",
                $this->_EMail => [
                    $this->_EMailAddress => $data[$this->_ShipToData][$this->_EmailData]
                ],
                $this->_Locale => [
                    $this->_Language => "POL",
                    $this->_Dialect => "97"
                ]
            ];
            $request->ShipmentRequest[$this->_Shipment]['ShipmentIndicationType'] = [
                "Code" => "01"
            ];
            $request->ShipmentRequest[$this->_Shipment][$this->_AlternateDeliveryAddressData] = [
                "Name" => $data[$this->_AlternateDeliveryAddressData]['Name'],
                "AttentionName" => $data[$this->_AlternateDeliveryAddressData][$this->_AttentionNameData],
                $this->_Address => [
                    "AddressLine" => $data[$this->_AlternateDeliveryAddressData][$this->_AddressData]
                        [$this->_AddressLineData],
                    "City" => $data[$this->_AlternateDeliveryAddressData][$this->_AddressData]['City'],
                    "StateProvinceCode" => $data[$this->_AlternateDeliveryAddressData][$this->_AddressData]
                        [$this->_StateProvinceCodeData],
                    "PostalCode" => $data[$this->_AlternateDeliveryAddressData][$this->_AddressData]
                        [$this->_PostalCodeData],
                    "CountryCode" => $data[$this->_AlternateDeliveryAddressData][$this->_AddressData]
                        [$this->_CountryCodeData]
                ]
            ];
        }
        $request->ShipmentRequest[$this->_Shipment][$this->_ShipmentServiceOptions]["Notification"] = $Notification;
        return $request;

    }
	
	/**
	* Shipping status
	*/
	
	public function ups_eu_woo_shipment_tracking($data, $upsSecurity) {
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->TrackRequest = [
            "Request" => [
                "RequestOption" => "",
                "TransactionReference" => [
                    "CustomerContext" => "",
                ]
            ],
            "InquiryNumber" => $data['InquiryNumber']
        ];
        return $request;
    }
	
	/**
	* Print Label
	*/
	 public function ups_eu_woo_shipment_label_recovery($data, $upsSecurity) {
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->LabelRecoveryRequest = [
            $this->_RequestOptionData => [
                'SubVersion' => '1701'
            ],
            'LabelSpecification' => [
                'LabelImageFormat' => [
                    'Code' => 'PDF',
                ],
                'HTTPUserAgent' => 'Mozilla/4.5',
            ],
            'Translate' => [
                'LanguageCode' => 'eng',
                'DialectCode' => 'GB',
                'Code' => '01',
            ],
            'TrackingNumber' => $data['TrackingNumber'],
        ];
        return $request;
    }
	
	/**
	* 6.1. Cancel Shipment
	*/
	
	public function ups_eu_woo_shipment_cancel_shipments($data, $upsSecurity) {
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
        $request->VoidShipmentRequest = [
            $this->_RequestData => [
                'TransactionReference' => [
                    'CustomerContext' => "",
                ]
            ],
            'VoidShipment' => [
                'ShipmentIdentificationNumber' => $data['ShipmentIdentificationNumber'],
            ]
        ];
        return $request;
    }
	
}
