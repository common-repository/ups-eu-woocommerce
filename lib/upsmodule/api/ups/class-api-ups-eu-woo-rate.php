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
 * Rate.php - The core plugin class.
 * 
 * This is used to get rate's shipping.
 */

class Ups_Eu_Woo_Rate 
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

    private $_ShipTo = "ShipTo";
	private $_Request = "Request";
	private $_RequestOption = "RequestOption";
	private $_Shipment = "Shipment";
	private $_Address = "Address";
	private $_AddressData = 'Address';
	private $_AddressLineData = 'AddressLine';
	private $_AddressLine = "AddressLine";
	private $_StateProvinceCode = "StateProvinceCode";
	private $_StateProvinceCodeData = 'StateProvinceCode';
	private $_PostalCodeData = 'PostalCode';
	private $_PostalCode = "PostalCode";
	private $_CountryCode = "CountryCode";
	private $_CountryCodeData = 'CountryCode';
	private $_PaymentDetailsData = 'PaymentDetails';
	private $_PaymentDetails = "PaymentDetails";
	private $_ShipmentCharge = "ShipmentCharge";
	private $_ShipmentChargeData = 'ShipmentCharge';
	private $_BillShipperData = 'BillShipper';
	private $_AccountNumber = 'AccountNumber';
	private $_Package = 'Package';
	private $_WeightData = 'Weight';
	private $_Weight = "Weight";
	private $_PackageWeight = "PackageWeight";
	private $_PackageWeightData = 'PackageWeight';
	private $_UnitOfMeasurementData = 'UnitOfMeasurement';
	private $_UnitOfMeasurement = "UnitOfMeasurement";
	private $_Description = "Description";
	private $_DescriptionData = 'Description';
	private $_accessorialsData = 'accessorials';
	private $_PackagingType = "PackagingType";
	private $_Dimensions = "Dimensions";
	private $_DimensionsData = 'Dimensions';
	private $_LengthData = 'Length';
	private $_Length = "Length";
	private $_Width = "Width";
	private $_WidthData = 'Width';
	private $_HeightData = 'Height';
	private $_Height = "Height";
	private $_PackageServiceOptions = "PackageServiceOptions";
	private $_AlternateDeliveryAddress = 'AlternateDeliveryAddress';
	private $_ServiceData = 'Service';
	private $_Service = "Service";
	private $_InvoiceLineTotal = "InvoiceLineTotal";
	private $_CurrencyCode = "CurrencyCode";
	private $_MonetaryValue = "MonetaryValue";
	private $_char_num = '([^a-zA-Z0-9.])';
	private $_ShipmentServiceOptions = "ShipmentServiceOptions";

    public function ups_eu_woo_rate_get_rates($data, $upsSecurity) {
        $request = new \stdClass();
        $request->UPSSecurity = $upsSecurity;
		
		$ShipTo = 'ShipTo';
		$Shipper = 'Shipper';
		$ShipFrom = 'ShipFrom';
		
        $request->RateRequest = [];
        $request->RateRequest = [
            $this->_Request => [
                $this->_RequestOption => $data['Request']['RequestOption'],
                "TransactionReference" => [
                    "CustomerContext" => ""
                ]
            ],
            $this->_Shipment => [
                "Shipper" => [ //Äá»‹a chá»‰ account 
                    "Name" => $data[$Shipper]['Name'],
                    "ShipperNumber" => $data[$Shipper]['ShipperNumber'],
                    $this->_Address => [
                        $this->_AddressLine => [
                            $data[$Shipper][$this->_AddressData][$this->_AddressLineData][0],
                            $data[$Shipper][$this->_AddressData][$this->_AddressLineData][1],
                            $data[$Shipper][$this->_AddressData][$this->_AddressLineData][2],
                        ],
                        "City" => $data[$Shipper][$this->_AddressData]['City'],
                        $this->_StateProvinceCode => 
                            $data[$Shipper][$this->_AddressData][$this->_StateProvinceCodeData],
                        $this->_PostalCode => $data[$Shipper][$this->_AddressData][$this->_PostalCodeData],
                        $this->_CountryCode => $data[$Shipper][$this->_AddressData][$this->_CountryCodeData]
                    ]
                ],
                $this->_ShipTo => [ // Äá»‹a chá»‰ e-shopper  $ShipTo
                    "Name" => $data[$ShipTo]['Name'],
                    $this->_Address => [
                        $this->_AddressLine => [
                            $data[$ShipTo][$this->_AddressData][$this->_AddressLineData][0],
                            $data[$ShipTo][$this->_AddressData][$this->_AddressLineData][1],
                            $data[$ShipTo][$this->_AddressData][$this->_AddressLineData][2]
                        ],
                        "City" => $data[$ShipTo][$this->_AddressData]['City'],
                        $this->_StateProvinceCode => 
                            $data[$ShipTo][$this->_AddressData][$this->_StateProvinceCodeData],
                        $this->_PostalCode => $data[$ShipTo][$this->_AddressData][$this->_PostalCodeData],
                        $this->_CountryCode => $data[$ShipTo][$this->_AddressData][$this->_CountryCodeData],
                    ]
                ],
                "ShipFrom" => [ //Äá»‹a chá»‰ account $ShipFrom
                    "Name" => $data[$ShipFrom]['Name'],
                    $this->_Address => [
                        $this->_AddressLine => [
                            $data[$ShipFrom][$this->_AddressData][$this->_AddressLineData][0],
                            $data[$ShipFrom][$this->_AddressData][$this->_AddressLineData][1],
                            $data[$ShipFrom][$this->_AddressData][$this->_AddressLineData][2]
                        ],
                        "City" => $data[$ShipFrom][$this->_AddressData]['City'],
                        $this->_StateProvinceCode => 
                            $data[$ShipFrom][$this->_AddressData][$this->_StateProvinceCodeData],
                        $this->_PostalCode => $data[$ShipFrom][$this->_AddressData][$this->_PostalCodeData],
                        $this->_CountryCode => $data[$ShipFrom][$this->_AddressData][$this->_CountryCodeData]
                    ]
                ],
                $this->_PaymentDetails => [
                    $this->_ShipmentCharge => [
                        [
                            "Type" => '01',
                            "BillShipper" => [
                                "AccountNumber" => $data[$this->_PaymentDetailsData][$this->_ShipmentChargeData]
                                    [$this->_BillShipperData][$this->_AccountNumber]
                            ]
                        ]
                    ]
                ],
                "ShipmentRatingOptions" => [
                    "NegotiatedRatesIndicator" => ""
                ]
            ]
        ];

        if (!in_array($data[$ShipTo][$this->_AddressData][$this->_CountryCodeData], self::COUNTRY_EU) || 
        isset($data[$this->_AlternateDeliveryAddress]) && 
        isset($data[$this->_AlternateDeliveryAddress][$this->_AddressData]) && 
        !in_array($data[$this->_AlternateDeliveryAddress][$this->_AddressData][$this->_CountryCodeData], 
        self::EIGHTEUCOUNTRY) && $data['ShippingType'] == 'AP' && isset($data[$this->_AlternateDeliveryAddress]['COD'])
        && $data[$this->_AlternateDeliveryAddress]['COD'] == '1') {
            $request->RateRequest[$this->_Shipment][$this->_PaymentDetails][$this->_ShipmentCharge][] = [
                'Type' => '02',
                $this->_BillShipperData => [
                    $this->_AccountNumber => $data[$this->_PaymentDetailsData][$this->_ShipmentChargeData]
                        [$this->_BillShipperData][$this->_AccountNumber]
                ]
            ];
        }

        $ShipmentTotalWidth = 0;
        $ShipmentTotalCode = "";
        $ShipmentTotalDescription = "";
        if (isset($data[$this->_Package])) {
            foreach ($data[$this->_Package] as $key => $value) {
                $ShipmentTotalWidth = $value[$this->_PackageWeightData][$this->_WeightData];
                $ShipmentTotalCode = $value[$this->_PackageWeightData][$this->_UnitOfMeasurementData]['Code'];
                $ShipmentTotalDescription = 
                    $value[$this->_PackageWeightData][$this->_UnitOfMeasurementData][$this->_DescriptionData];
                if (isset($data[$this->_accessorialsData]) && array_key_exists('UPS_ACSRL_ADDITIONAL_HADING', 
                    $data[$this->_accessorialsData])) {
                    $Package[] = [
                        $this->_PackagingType => [
                            "Code" => "02",
                            $this->_Description => "Rate"
                        ],
                        $this->_Dimensions => [
                            $this->_UnitOfMeasurement => [
                                "Code" => 
                                strtoupper($value[$this->_DimensionsData][$this->_UnitOfMeasurementData]['Code']),
                                $this->_Description => 
                                $value[$this->_DimensionsData][$this->_UnitOfMeasurementData][$this->_DescriptionData]
                            ],
                            $this->_Length => $value[$this->_DimensionsData][$this->_LengthData],
                            $this->_Width => $value[$this->_DimensionsData][$this->_WidthData],
                            $this->_Height => $value[$this->_DimensionsData][$this->_HeightData]
                        ],
                        $this->_PackageWeight => [
                            $this->_UnitOfMeasurement => [
                                "Code" => 
                                strtoupper($value[$this->_PackageWeightData][$this->_UnitOfMeasurementData]['Code']),
                                $this->_Description => $value[$this->_PackageWeightData]
                                    [$this->_UnitOfMeasurementData][$this->_DescriptionData]
                            ],
                            $this->_Weight => $value[$this->_PackageWeightData][$this->_WeightData]
                        ],
                        $this->_PackagingType => [
                            "Code" => "02",
                        ],
                        "AdditionalHandlingIndicator" => "",
                        $this->_PackageServiceOptions => []
                    ];
                } else {
                    $Package[] = [
                        $this->_Dimensions => [
                            $this->_UnitOfMeasurement => [
                                "Code" => 
                                strtoupper($value[$this->_DimensionsData][$this->_UnitOfMeasurementData]['Code']),
                                $this->_Description => $value[$this->_DimensionsData]
                                    [$this->_UnitOfMeasurementData][$this->_DescriptionData]
                            ],
                            $this->_Length => $value[$this->_DimensionsData][$this->_LengthData],
                            $this->_Width => $value[$this->_DimensionsData][$this->_WidthData],
                            $this->_Height => $value[$this->_DimensionsData][$this->_HeightData]
                        ],
                        $this->_PackageWeight => [
                            $this->_UnitOfMeasurement => [
                                "Code" => 
                                strtoupper($value[$this->_PackageWeightData][$this->_UnitOfMeasurementData]['Code']),
                                $this->_Description => $value[$this->_PackageWeightData]
                                [$this->_UnitOfMeasurementData][$this->_DescriptionData]
                            ],
                            $this->_Weight => $value[$this->_PackageWeightData][$this->_WeightData]
                        ],
                        $this->_PackagingType => [
                            "Code" => "02",
                            $this->_Description => "Rate"
                        ],
                        $this->_PackageServiceOptions => [],
                    ];
                }
            }
        }

        if ($data['ShippingType'] == 'AP' && isset($data[$this->_AlternateDeliveryAddress])) {
            $request->RateRequest[$this->_Shipment]['ShipmentIndicationType'] = [
                "Code" => "01"
            ];
            $request->RateRequest[$this->_Shipment][$this->_AlternateDeliveryAddress] = [
                "Name" => $data[$this->_AlternateDeliveryAddress]['Name'],
                "AttentionName" => $data[$this->_AlternateDeliveryAddress]['AttentionName'],
                $this->_Address => [
                    $this->_AddressLine => 
                    $data[$this->_AlternateDeliveryAddress][$this->_AddressData][$this->_AddressLineData],
                    "City" => $data[$this->_AlternateDeliveryAddress][$this->_AddressData]['City'],
                    $this->_StateProvinceCode => $data[$this->_AlternateDeliveryAddress][$this->_AddressData]
                    [$this->_StateProvinceCodeData],
                    $this->_PostalCode => $data[$this->_AlternateDeliveryAddress][$this->_AddressData]
                    [$this->_PostalCodeData],
                    $this->_CountryCode => $data[$this->_AlternateDeliveryAddress][$this->_AddressData]
                    [$this->_CountryCodeData]
                ]
            ];
        }

        if ($data[$this->_Request][$this->_RequestOption] == "RATETIMEINTRANSIT") {
            $request->RateRequest[$this->_Request]["SubVersion"] = "1801";
            if (isset($data[$this->_Service])) {
                $request->RateRequest[$this->_Shipment][$this->_Service] = [
                    "Code" => $data[$this->_ServiceData]['Code'],
                    $this->_Description => $data[$this->_ServiceData][$this->_DescriptionData]
                ];
            }
            $request->RateRequest[$this->_Shipment]["DeliveryTimeInformation"] = [
                "PackageBillType" => "03",
                "Pickup" => [
                    "Date" => $data['DeliveryTimeInformation']['Pickup']['Date']
                ]
            ];
            if (isset($data['InvoiceLineTotal'])) {
                $request->RateRequest[$this->_Shipment][$this->_InvoiceLineTotal] = [ // thÃ´ng tin tiá»n tá»‡
                    $this->_CurrencyCode => $data[$this->_InvoiceLineTotal][$this->_CurrencyCode],
                    $this->_MonetaryValue => 
                    preg_replace($this->_char_num, '', (string) $data[$this->_InvoiceLineTotal][$this->_MonetaryValue])
                ];
            }

            $request->RateRequest[$this->_Shipment]["ShipmentTotalWeight"] = [
                $this->_UnitOfMeasurement => [
                    "Code" => strtoupper($ShipmentTotalCode),
                    $this->_Description => $ShipmentTotalDescription
                ],
                $this->_Weight => $ShipmentTotalWidth
            ];
        }

        if (isset($data[$this->_accessorialsData])) {
            foreach ($data[$this->_accessorialsData] as $key => $value) {
                switch ($key) {
                    case 'UPS_ACSRL_QV_SHIP_NOTIF':
                        break;
                    case 'UPS_ACSRL_QV_DLV_NOTIF':
                        break;
                    case 'UPS_ACSRL_RESIDENTIAL_ADDRESS':
                        $request->RateRequest[$this->_Shipment][$this->_ShipTo][$this->_Address]
                        ["ResidentialAddressIndicator"] = "1";
                        break;
                    case 'UPS_ACSRL_STATURDAY_DELIVERY':
                        $request->RateRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                        ["SaturdayDeliveryIndicator"] = "";
                        break;
                    case 'UPS_ACSRL_CARBON_NEUTRAL':
                        $request->RateRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                        ["UPScarbonneutralIndicator"] = "";
                        break;
                    case 'UPS_ACSRL_DIRECT_DELIVERY_ONLY':
                        $request->RateRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                        ["DirectDeliveryOnlyIndicator"] = "";
                        break;
                    case 'UPS_ACSRL_DECLARED_VALUE':
                        foreach ($Package as $key => $value) {
                            $Package[$key][$this->_PackageServiceOptions] = [
                                "DeclaredValue" => [
                                    "Type" => [
                                        "Code" => "01",
                                        "Descripton" => "EVS"
                                    ],
                                    $this->_CurrencyCode => $data[$this->_InvoiceLineTotal][$this->_CurrencyCode],
                                    $this->_MonetaryValue => preg_replace($this->_char_num, '', 
                                    (string) $data[$this->_InvoiceLineTotal][$this->_MonetaryValue])
                                ]
                            ];
                        }
                        break;
                    case 'UPS_ACSRL_SIGNATURE_REQUIRED':
                        $request->RateRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                        ["DeliveryConfirmation"]["DCISType"] = "1";
                        break;
                    case 'UPS_ACSRL_ADULT_SIG_REQUIRED':
                        $request->RateRequest[$this->_Shipment][$this->_ShipmentServiceOptions]
                        ["DeliveryConfirmation"]["DCISType"] = "2";
                        break;
                    case 'UPS_ACSRL_ACCESS_POINT_COD':
                        $request->RateRequest[$this->_Shipment][$this->_ShipmentServiceOptions]["AccessPointCOD"] = [
                            $this->_CurrencyCode => $data[$this->_InvoiceLineTotal][$this->_CurrencyCode],
                            $this->_MonetaryValue => preg_replace($this->_char_num, '', 
                            (string) $data[$this->_InvoiceLineTotal][$this->_MonetaryValue])
                        ];
                        break;
                    case 'UPS_ACSRL_TO_HOME_COD':
                        $request->RateRequest[$this->_Shipment][$this->_ShipmentServiceOptions]["COD"] = [
                            "CODFundsCode" => '1',
                            "CODAmount" => [
                                $this->_CurrencyCode => $data[$this->_InvoiceLineTotal][$this->_CurrencyCode],
                                $this->_MonetaryValue => preg_replace($this->_char_num, '', 
                                (string) $data[$this->_InvoiceLineTotal][$this->_MonetaryValue])
                            ]
                        ];
                        break;                        
                    default:
                        break;
                }
            }
        }
        $request->RateRequest[$this->_Shipment]["Package"] = $Package;
        return  $request;
    }
}
