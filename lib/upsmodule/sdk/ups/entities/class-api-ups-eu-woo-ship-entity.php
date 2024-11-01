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

class Ups_Eu_Woo_Ship_Entity
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
        "CanaryIslands" => "IC",
        "Norway" => "NO",
        "Serbia" => "RS,",
        "Switzerland" => "CH",
        "Iceland" => "IS",
        "Jersey" => "JE",
        "Turkey" => "TR",
    ];

    const EIGHTEUCOUNTRY = ['BE', 'NL', 'FR', 'ES', 'PL', 'IT', 'DE', 'UK', 'AT', 'BG', 'HR', 'CY', 'CZ', 'DK', 'EE', 'FI', 'GR', 'HU', 'IE', 'LV', 'LT', 'LU', 'MT', 'PT',  'RO', 'SK', 'SI', 'SE', 'NO', 'RS', 'CH', 'IS', 'JE', 'TR'];
    const RATETIMEINTRANSIT = 'RATETIMEINTRANSIT';
    const SHOPTIMEINTRANSIT = 'SHOPTIMEINTRANSIT';

    public $Shipment;
    public $Shipper;
    public $ShipTo;
    public $ShipFrom;
    public $Name = "Name";
    public $AttentionName = "AttentionName";
    public $Phone;
    public $Number = "Number";
    public $ShipperNumber = "ShipperNumber";
    public $Address;
    public $AddressLine = "AddressLine";
    public $City = "City";
    public $StateProvinceCode = "StateProvinceCode";
    public $PostalCode = "PostalCode";
    public $CountryCode = "CountryCode";
    public $EMailAddress ="EMailAddress";

    public $PaymentDetails;
    public $PaymentInformation;
    public $ShipmentCharge;
    public $Type = "Type";
    public $BillShipper;
    public $AccountNumber = "AccountNumber";

    public $ShipmentRatingOptions;
    public $NegotiatedRatesIndicator = "NegotiatedRatesIndicator";

    public $AlternateDeliveryAddress;

    public $RequestOption;
    public $SubVersion = "SubVersion";
    public $LabelSpecification;
    public $LabelImageFormat;
    public $Code = "Code";
    public $HTTPUserAgent = "HTTPUserAgent";
    public $Translate;
    public $LanguageCode = "LanguageCode";
    public $DialectCode = "DialectCode";
    public $TrackingNumber = "TrackingNumber";

    public $VoidShipment;
    public $ShipmentIdentificationNumber = "ShipmentIdentificationNumber";

    public $Service;
    public $Description = "Description";

    private $char_num = "([^a-zA-Z0-9.])";

    public function setRate($data)
    {
        $this->Shipment = new \stdClass();
        $this->setShipper($data->shipper);
        $this->Shipment->Shipper = $this->Shipper;
        $this->setShipTo($data->shipto);
        $this->Shipment->ShipTo = $this->ShipTo;
        $this->setShipFrom($data->shipfrom);
        $this->Shipment->ShipFrom = $this->ShipFrom;
        $this->setPaymentDetail($data);
        $this->Shipment->PaymentDetails = $this->PaymentDetails;
        $this->setShipmentRatingOption($data);
        $this->Shipment->ShipmentRatingOptions = $this->ShipmentRatingOptions;
    }

    public function setShipment($data)
    {
        $this->Shipment = new \stdClass();
        $this->Shipment->{$this->Description} = $this->Description;
        $this->setShipper($data->shipper);
        $this->Shipment->Shipper = $this->Shipper;
        $this->setShipTo($data->shipto);
        $this->Shipment->ShipTo = $this->ShipTo;
        $this->setShipFrom($data->shipfrom);
        $this->Shipment->ShipFrom = $this->ShipFrom;
        $this->setServiceShipment($data);
        $this->Shipment->Service = $this->Service;
        $this->setPaymentInformation($data);
        $this->Shipment->PaymentInformation = $this->PaymentInformation;
        $this->setLabelSpecification("Shipment");
        $this->Shipment->LabelSpecification = $this->LabelSpecification;
        $this->setShipmentRatingOption($data);
        $this->Shipment->ShipmentRatingOptions = $this->ShipmentRatingOptions;
    }

    public function setShipper($data_shipper)
    {
        $this->Shipper = new \stdClass();
        $this->Shipper->{$this->Name} = $data_shipper->name;
        if (isset($data_shipper->attention_name)) {
            $this->Shipper->{$this->AttentionName} = $data_shipper->attention_name;
        }
        if (isset($data_shipper->phone_number)) {
            $this->Phone = new \stdClass();
            $this->Phone->{$this->Number} = $data_shipper->phone_number;
            $this->Shipper->Phone = $this->Phone;
        }
        $this->Shipper->{$this->ShipperNumber} = $data_shipper->shipper_number;
        if (isset($data_shipper->email)) {
            $this->Shipper->{$this->EMailAddress} = $data_shipper->email;
        }
        $this->setAddress($data_shipper);
        $this->Shipper->Address = $this->Address;
    }

    public function setShipTo($data_shipto)
    {
        $this->ShipTo = new \stdClass();
        $this->ShipTo->{$this->Name} = $data_shipto->name;
        if (isset($data_shipto->attention_name)) {
            $this->ShipTo->{$this->AttentionName} = $data_shipto->attention_name;
        }
        if (isset($data_shipto->phone_number)) {
            $this->Phone = new \stdClass();
            $this->Phone->{$this->Number} = $data_shipto->phone_number;
            $this->ShipTo->Phone = $this->Phone;
        }
        if (isset($data_shipto->email)) {
            $this->ShipTo->{$this->EMailAddress} = $data_shipto->email;
        }
        $this->setAddress($data_shipto, 'ship_to');
        $this->ShipTo->Address = $this->Address;
    }

    public function setShipFrom($data_shipfrom)
    {
        $this->ShipFrom = new \stdClass();
        $this->ShipFrom->{$this->Name} = $data_shipfrom->name;
        if (isset($data_shipfrom->attention_name)) {
            $this->ShipFrom->{$this->AttentionName} = $data_shipfrom->attention_name;
        }
        if (isset($data_shipfrom->phone_number)) {
            $this->Phone = new \stdClass();
            $this->Phone->{$this->Number} = $data_shipfrom->phone_number;
            $this->ShipFrom->Phone = $this->Phone;
        }
        $this->setAddress($data_shipfrom);
        $this->ShipFrom->Address = $this->Address;
    }

    public function setAlternateDeliveryAddress($data_alternate)
    {
        $this->AlternateDeliveryAddress = new \stdClass();
        $this->AlternateDeliveryAddress->{$this->Name} = $data_alternate->name;
        $this->AlternateDeliveryAddress->{$this->AttentionName} = $data_alternate->attention_name;
        $this->setAddress($data_alternate);
        $this->AlternateDeliveryAddress->Address = $this->Address;
    }

    private function setAddress($data, $ship_to = '')
    {
        $arr_not_xx = ['CA', 'US', 'IE'];
        $state_code = $data->state_code;
        if (!empty($ship_to) && !in_array($data->country_code, $arr_not_xx) && strlen($data->state_code) > 5) {
            $state_code = substr($data->state_code, 0, 5);
        }
        $this->Address = new \stdClass();
        $this->Address->{$this->AddressLine} = $data->address_line;
        $this->Address->{$this->City} = $data->city;
        $this->Address->{$this->StateProvinceCode} =  $state_code;
        $this->Address->{$this->PostalCode} = $data->post_code;
        $this->Address->{$this->CountryCode} = $data->country_code;
        $allowState = ['GC', 'TF'];
        if ($this->Address->{$this->CountryCode} == 'ES' && !empty($ship_to)) {
            if (in_array($this->Address->{$this->StateProvinceCode}, $allowState)) {
                $this->Address->{$this->CountryCode} = 'IC';
            }
        }
    }

    private function setPaymentDetail($data)
    {
        $this->PaymentDetails = new \stdClass();
        $this->ShipmentCharge = [];
        $shipment_charge_item = new \stdClass();
        $shipment_charge_item->{$this->Type} = "01";
        $shipment_charge_item->BillShipper = new \stdClass();
        $shipment_charge_item->BillShipper->{$this->AccountNumber} = $data->account_number;
        $this->ShipmentCharge[] = $shipment_charge_item;
        $this->PaymentDetails->ShipmentCharge = $this->ShipmentCharge;
    }

    private function setPaymentInformation($data)
    {
        $this->PaymentInformation = new \stdClass();
        $this->ShipmentCharge = [];
        $shipment_charge_item = new \stdClass();
        $shipment_charge_item->{$this->Type} = "01";
        $shipment_charge_item->BillShipper = new \stdClass();
        $shipment_charge_item->BillShipper->{$this->AccountNumber} = $data->account_number;
        $this->ShipmentCharge[] = $shipment_charge_item;
        $this->PaymentInformation->ShipmentCharge = $this->ShipmentCharge;
    }

    private function setServiceShipment($data)
    {
        $this->Service = new \stdClass();
        $this->Service->{$this->Code} = $data->service->code;
        $this->Service->{$this->Description} = $data->service->description;
    }

    private function setShipmentRatingOption($data)
    {
        $this->ShipmentRatingOptions = new \stdClass();
        $this->ShipmentRatingOptions->{$this->NegotiatedRatesIndicator} = "";
    }

    public function setRequestOption()
    {
        $this->RequestOption = new \stdClass();
        $this->RequestOption->{$this->SubVersion} = "1701";
    }

    public function setLabelSpecification($option)
    {
        $this->LabelSpecification = new \stdClass();
        $this->LabelImageFormat = new \stdClass();
        if ($option == "ZPL" || $option == "PDF") {
            $this->LabelImageFormat->{$this->Code} = $option;
        } else {
            $this->LabelImageFormat->{$this->Code} = "GIF";
            $this->LabelImageFormat->{$this->Description} = "GIF";
        }
        $this->LabelSpecification->LabelImageFormat = $this->LabelImageFormat;
        $this->LabelSpecification->{$this->HTTPUserAgent} = "Mozilla/4.5";
    }

    public function setTranslate()
    {
        $this->Translate = new \stdClass();
        $this->Translate->{$this->LanguageCode} = "en";
        $this->Translate->{$this->DialectCode} = "GB";
        $this->Translate->{$this->Code} = "01";
    }

    public function setVoidShipment($data)
    {
        $this->VoidShipment = new \stdClass();
        $this->VoidShipment->{$this->ShipmentIdentificationNumber} = $data->shipment_number;
    }

    public function setCountryInEU(&$request, $data, $option = "Rate")
    {
        if (!in_array($data->shipto->country_code, self::COUNTRY_EU) ||
            isset($data->alternate_delivery_address) &&
            !in_array($data->alternate_delivery_address->country_code, self::EIGHTEUCOUNTRY) &&
            $data->shipping_type == 'AP' &&
            isset($data->alternate_delivery_address->cod) &&
            $data->alternate_delivery_address->cod == '1'
        ) {
            $shipment_charge_item = new \stdClass();
            $shipment_charge_item->{$this->Type} = "02";
            $shipment_charge_item->BillShipper = new \stdClass();
            $shipment_charge_item->BillShipper->{$this->AccountNumber} = $data->account_number;
            if ($option != "Rate") {
                $request->ShipmentRequest->Shipment->PaymentInformation->ShipmentCharge[] = $shipment_charge_item;
            } else {
                $request->RateRequest->Shipment->PaymentDetails->ShipmentCharge[] = $shipment_charge_item;
            }
        }
    }

    public function setPackageShipment($data)
    {
        $package = [];
        if (isset($data->package)) {
            $from_country = $data->shipfrom->country_code;
            $to_country = $data->shipto->country_code;
            $package_service_options = new \stdClass();
            if ($from_country == 'US' && $to_country == 'US') {
                $value_dcis_type = 0;
                if (isset($data->accessorial)) {
                    if (array_key_exists('UPS_ACSRL_SIGNATURE_REQUIRED', $data->accessorial)) {
                        $value_dcis_type = 2;
                    }

                    if (array_key_exists('UPS_ACSRL_ADULT_SIG_REQUIRED', $data->accessorial)) {
                        $value_dcis_type = 3;
                    }
                }
                if ($value_dcis_type > 0) {
                    $package_service_options->DeliveryConfirmation->DCISType = (string)$value_dcis_type;
                }
            }
            if (in_array(strtolower($to_country), ['us', 'ca', 'mx', 'pr'])) {
                if (!empty($data->accessorial)) {
                    if (array_key_exists('UPS_ACSRL_TO_HOME_COD', $data->accessorial)) {
                        $cod_data = new \stdClass();
                        $cod_data->CODFundsCode = "0";
                        $amount_data = new \stdClass();
                        $amount_data->CurrencyCode = (string) $data->currency_code;
                        $amount_data->MonetaryValue = (string) $data->monetary_value;
                        $cod_data->CODAmount = $amount_data;
                        $package_service_options->COD = $cod_data;
                    }
                }
            }
            foreach ($data->package as $value) {
                $packages_item = new \stdClass();
                if (isset($value->dimension)) {
                    $packages_item->Dimensions = new \stdClass();
                    $packages_item->Dimensions->UnitOfMeasurement = new \stdClass();
                    $packages_item->Dimensions->UnitOfMeasurement->Code = (strtoupper($value->dimension->code) == 'INCH') ? 'IN' : strtoupper($value->dimension->code);
                    $packages_item->Dimensions->UnitOfMeasurement->Description = $value->dimension->description;
                    $packages_item->Dimensions->Length = $value->dimension->length;
                    $packages_item->Dimensions->Width = $value->dimension->width;
                    $packages_item->Dimensions->Height = $value->dimension->height;
                }

                $packages_item->PackageWeight = new \stdClass();
                $packages_item->PackageWeight->UnitOfMeasurement = new \stdClass();
                $packages_item->PackageWeight->UnitOfMeasurement->Code = strtoupper($value->package_weight->code);
                $packages_item->PackageWeight->UnitOfMeasurement->Description = $value->package_weight->description;
                $packages_item->PackageWeight->Weight = $value->package_weight->weight;

                $packages_item->Packaging = new \stdClass();
                $packages_item->Packaging->Code = $data->package_type;
                $packages_item->PackagingType = new \stdClass();
                $packages_item->PackagingType->Code = isset($data->package_type) ? $data->package_type : "02";

                $packages_item->PackageServiceOptions = $package_service_options;

                if (isset($data->accessorial) && array_key_exists('UPS_ACSRL_ADDITIONAL_HADING', $data->accessorial)) {
                    $packages_item->AdditionalHandlingIndicator = "";
                }

                if (isset($data->accessorial) && array_key_exists('UPS_ACSRL_ADDITIONAL_HADING', $data->accessorial)) {
                    $packages_item->AdditionalHandlingIndicator = "";
                }
                if (isset($data->accessorial) && array_key_exists('UPS_ACSRL_DECLARED_VALUE', $data->accessorial)) {
                    $packages_item->PackageServiceOptions->DeclaredValue = new \stdClass();
                    $packages_item->PackageServiceOptions->DeclaredValue->Type = new \stdClass();
                    $packages_item->PackageServiceOptions->DeclaredValue->Type->Code = "01";
                    $packages_item->PackageServiceOptions->DeclaredValue->Type->Descripton = "EVS";
                    $packages_item->PackageServiceOptions->DeclaredValue->CurrencyCode = (string)$data->currency_code;
                    $packages_item->PackageServiceOptions->DeclaredValue->MonetaryValue = (string)$data->monetary_value;
                }

                $package[] = $packages_item;
            }
        }
        return $package;
    }

    public function setPackage(&$shipment_total_weight, &$shipment_total_code, &$shipment_total_description, $data)
    {
        $package = [];
        if (isset($data->package)) {
            $from_country = $data->shipfrom->country_code;
            $to_country = $data->shipto->country_code;
            $package_service_options = new \stdClass();
            if ($from_country == 'US' && $to_country == 'US') {
                $value_dcis_type = 0;
                if (isset($data->accessorial)) {
                    if (array_key_exists('UPS_ACSRL_SIGNATURE_REQUIRED', $data->accessorial)) {
                        $value_dcis_type = 2;
                    }

                    if (array_key_exists('UPS_ACSRL_ADULT_SIG_REQUIRED', $data->accessorial)) {
                        $value_dcis_type = 3;
                    }
                }
                if ($value_dcis_type > 0) {
                    $package_service_options->DeliveryConfirmation->DCISType = (string)$value_dcis_type;
                }
            }
            if (in_array(strtolower($to_country), ['us', 'ca', 'mx', 'pr'])) {
                if (!empty($data->accessorial)) {
                    if (array_key_exists('UPS_ACSRL_TO_HOME_COD', $data->accessorial)) {
                        $cod_data = new \stdClass();
                        $cod_data->CODFundsCode = "0";
                        $amount_data = new \stdClass();
                        $amount_data->CurrencyCode = (string) $data->invoice_line_total->currency_code;
                        $amount_data->MonetaryValue = (string) $data->invoice_line_total->monetary_value;
                        $cod_data->CODAmount = $amount_data;
                        $package_service_options->COD = $cod_data;
                    }
                }
            }
            foreach ($data->package as $key => $value) {
                $shipment_total_weight += $value->package_weight->weight;
                $shipment_total_code = $value->package_weight->code;
                $shipment_total_description = $value->package_weight->description;

                $packages_item = new \stdClass();
                if (isset($value->dimension) && !is_null($value->dimension->length) && !is_null($value->dimension->width) && !is_null($value->dimension->height)) {
                    $packages_item->Dimensions = new \stdClass();
                    $packages_item->Dimensions->UnitOfMeasurement = new \stdClass();
                    $packages_item->Dimensions->UnitOfMeasurement->Code = (strtoupper($value->dimension->code) == 'INCH') ? 'IN' : strtoupper($value->dimension->code);
                    $packages_item->Dimensions->UnitOfMeasurement->Description = $value->dimension->description;
                    $packages_item->Dimensions->Length = $value->dimension->length;
                    $packages_item->Dimensions->Width = $value->dimension->width;
                    $packages_item->Dimensions->Height = $value->dimension->height;
                }

                $packages_item->PackageWeight = new \stdClass();
                $packages_item->PackageWeight->UnitOfMeasurement = new \stdClass();
                $packages_item->PackageWeight->UnitOfMeasurement->Code = strtoupper($value->package_weight->code);
                $packages_item->PackageWeight->UnitOfMeasurement->Description = $value->package_weight->description;
                $packages_item->PackageWeight->Weight = $value->package_weight->weight;

                $packages_item->PackagingType = new \stdClass();
                
                $packages_item->PackagingType->Code = isset($data->package_type) ? $data->package_type : "02";
                $packages_item->PackagingType->Description = "Rate";

                if (isset($data->accessorial) && array_key_exists('UPS_ACSRL_ADDITIONAL_HADING', $data->accessorial)) {
                    $packages_item->AdditionalHandlingIndicator = "";
                }

                $packages_item->PackageServiceOptions = $package_service_options;
                $package[] = $packages_item;
            }
        }
        return $package;
    }

    public function setAlternateDeliveryAddressOfRate(&$request, $data)
    {
        if ($data->shipping_type == 'AP' && isset($data->alternate_delivery_address)) {
            $request->RateRequest->Shipment->ShipmentIndicationType = new \stdClass();
            $ShipmentIndicationType = isset($data->ShipmentRequest->Shipment->ShipmentIndicationType->Code) ? $data->ShipmentRequest->Shipment->ShipmentIndicationType->Code : "01";
            if($ShipmentIndicationType == 02){
                $request->RateRequest->Shipment->ShipmentIndicationType->Code = $ShipmentIndicationType;
            }else{
                $request->RateRequest->Shipment->ShipmentIndicationType->Code = apply_filters("ups_shipment_identification_number", "01");
            }
            $this->setAlternateDeliveryAddress($data->alternate_delivery_address);
            $request->RateRequest->Shipment->AlternateDeliveryAddress = $this->AlternateDeliveryAddress;
        }
    }

    public function setTimeInTransit(&$request, $data, $shipment_total)
    {
        if ($data->request_option == self::RATETIMEINTRANSIT || $data->request_option == self::SHOPTIMEINTRANSIT) {
            $request->RateRequest->Request->SubVersion = "1801";
            if (isset($data->service) && $data->request_option != self::SHOPTIMEINTRANSIT) {
                $request->RateRequest->Shipment->Service = new \stdClass();
                $request->RateRequest->Shipment->Service->Code = $data->service->code;
                $request->RateRequest->Shipment->Service->Description = $data->service->description;
            }

            $request->RateRequest->Shipment->DeliveryTimeInformation = new \stdClass();
            $request->RateRequest->Shipment->DeliveryTimeInformation->PackageBillType = "03";
            $request->RateRequest->Shipment->DeliveryTimeInformation->Pickup = new \stdClass();
            $request->RateRequest->Shipment->DeliveryTimeInformation->Pickup->Date = $data->pickup_date;

            if (isset($data->invoice_line_total)) {
                $currency_code = $data->invoice_line_total->currency_code;
                $monetary_value = preg_replace($this->char_num, '', (string) $data->invoice_line_total->monetary_value);
                $request->RateRequest->Shipment->InvoiceLineTotal = new \stdClass();
                $request->RateRequest->Shipment->InvoiceLineTotal->CurrencyCode = (string)$currency_code;
                $request->RateRequest->Shipment->InvoiceLineTotal->MonetaryValue = (string)$monetary_value;
            }

            $code = strtoupper($shipment_total->code);
            $description = $shipment_total->description;
            $request->RateRequest->Shipment->ShipmentTotalWeight = new \stdClass();
            $request->RateRequest->Shipment->ShipmentTotalWeight->UnitOfMeasurement = new \stdClass();
            $request->RateRequest->Shipment->ShipmentTotalWeight->UnitOfMeasurement->Code = $code;
            $request->RateRequest->Shipment->ShipmentTotalWeight->UnitOfMeasurement->Description = $description;
            $request->RateRequest->Shipment->ShipmentTotalWeight->Weight = trim($shipment_total->weight);
        }
    }

    public function setInvoiceLineTotal(&$request, $data)
    {
        if (isset($data->invoice_line_total)) {
            $currency_code = $data->invoice_line_total->currency_code;
            $monetary_value = preg_replace($this->char_num, '', (string) $data->invoice_line_total->monetary_value);
            $request->ShipmentRequest->Shipment->InvoiceLineTotal = new \stdClass();
            $request->ShipmentRequest->Shipment->InvoiceLineTotal->CurrencyCode = (string)$currency_code;
            $request->ShipmentRequest->Shipment->InvoiceLineTotal->MonetaryValue = (string)$monetary_value;
        }
    }

    public function setAccessorialOfRate(&$request, &$package, $data)
    {
        if (isset($data->accessorial)) {
            $from_country = $data->shipfrom->country_code;
            $to_country = $data->shipto->country_code;
            $request->RateRequest->Shipment->ShipmentServiceOptions = new \stdClass();
            foreach ($data->accessorial as $key => $value) {
                switch ($key) {
                    case 'UPS_ACSRL_QV_SHIP_NOTIF':
                        break;
                    case 'UPS_ACSRL_QV_DLV_NOTIF':
                        break;
                    case 'UPS_ACSRL_RESIDENTIAL_ADDRESS':
                        $request->RateRequest->Shipment->ShipTo->Address->ResidentialAddressIndicator = "1";
                        break;
                    case 'UPS_ACSRL_STATURDAY_DELIVERY':
                        $indicator = '';
                        if (in_array(strtolower($to_country), ['us'])) {
                            $indicator = '1';
                        }
                        $request->RateRequest->Shipment->ShipmentServiceOptions->SaturdayDeliveryIndicator = $indicator;
                        break;
                    case 'UPS_ACSRL_CARBON_NEUTRAL':
                        $request->RateRequest->Shipment->ShipmentServiceOptions->UPScarbonneutralIndicator = "";
                        break;
                    case 'UPS_ACSRL_DIRECT_DELIVERY_ONLY':
                        $request->RateRequest->Shipment->ShipmentServiceOptions->DirectDeliveryOnlyIndicator = "";
                        break;
                    case 'UPS_ACSRL_DECLARED_VALUE':
                        $currency_code = $data->invoice_line_total->currency_code;
                        $monetary_value = preg_replace($this->char_num, '', $data->invoice_line_total->monetary_value);
                        foreach ($package as $key => $value) {
                            $package[$key]->PackageServiceOptions->DeclaredValue = new \stdClass();
                            $package[$key]->PackageServiceOptions->DeclaredValue->Type = new \stdClass();
                            $package[$key]->PackageServiceOptions->DeclaredValue->Type->Code = "01";
                            $package[$key]->PackageServiceOptions->DeclaredValue->Type->Descripton = "EVS";
                            $package[$key]->PackageServiceOptions->DeclaredValue->CurrencyCode = (string)$currency_code;
                            $package[$key]->PackageServiceOptions->DeclaredValue->MonetaryValue = (string)$monetary_value;
                        }
                        break;
                    case 'UPS_ACSRL_SIGNATURE_REQUIRED':
                        if ($from_country != 'US' || $to_country != 'US') {
                            $request->RateRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation = new \stdClass();
                            $request->RateRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation->DCISType = "1";
                        }
                        break;
                    case 'UPS_ACSRL_ADULT_SIG_REQUIRED':
                        if ($from_country != 'US' || $to_country != 'US') {
                            $request->RateRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation = new \stdClass();
                            $request->RateRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation->DCISType = "2";
                        }
                        break;
                    case 'UPS_ACSRL_ACCESS_POINT_COD':
                        $currency_code = $data->invoice_line_total->currency_code;
                        $monetary_value = preg_replace($this->char_num, '', $data->invoice_line_total->monetary_value);
                        $request->RateRequest->Shipment->ShipmentServiceOptions->AccessPointCOD = new \stdClass();
                        $request->RateRequest->Shipment->ShipmentServiceOptions->AccessPointCOD->CurrencyCode = (string)$currency_code;
                        $request->RateRequest->Shipment->ShipmentServiceOptions->AccessPointCOD->MonetaryValue = (string)$monetary_value;
                        break;
                    case 'UPS_ACSRL_TO_HOME_COD':
                        if (!in_array(strtolower($to_country), ['us', 'ca', 'mx', 'pr'])) {
                            $currency_code = $data->invoice_line_total->currency_code;
                            $monetary_value = preg_replace($this->char_num, '', $data->invoice_line_total->monetary_value);
                            $request->RateRequest->Shipment->ShipmentServiceOptions->COD = new \stdClass();
                            $request->RateRequest->Shipment->ShipmentServiceOptions->COD->CODFundsCode = "1";
                            $request->RateRequest->Shipment->ShipmentServiceOptions->COD->CODAmount = new \stdClass();
                            $request->RateRequest->Shipment->ShipmentServiceOptions->COD->CODAmount->CurrencyCode = (string)$currency_code;
                            $request->RateRequest->Shipment->ShipmentServiceOptions->COD->CODAmount->MonetaryValue = (string)$monetary_value;
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function setAccessorialOfShipment(&$request, &$Notification, $data)
    {
        if (isset($data->accessorial)) {
            $from_country = $data->shipfrom->country_code;
            $to_country = $data->shipto->country_code;
            $request->ShipmentRequest->Shipment->ShipmentServiceOptions = new \stdClass();
            foreach ($data->accessorial as $key => $value) {
                switch ($key) {
                    case 'UPS_ACSRL_ADDITIONAL_HADING':
                        break;
                    case 'UPS_ACSRL_QV_SHIP_NOTIF':
                        $this->setNotification($data, $Notification, '6');
                        break;
                    case 'UPS_ACSRL_QV_DLV_NOTIF':
                        $this->setNotification($data, $Notification, '8');
                        break;
                    case 'UPS_ACSRL_RESIDENTIAL_ADDRESS':
                        $request->ShipmentRequest->Shipment->ShipTo->Address->ResidentialAddressIndicator = "1";
                        break;
                    case 'UPS_ACSRL_STATURDAY_DELIVERY':
                        $indicator = '';
                        if (in_array(strtolower($to_country), ['us'])) {
                            $indicator = '1';
                        }
                        $request->ShipmentRequest->Shipment->ShipmentServiceOptions->SaturdayDeliveryIndicator = $indicator;
                        break;
                    case 'UPS_ACSRL_CARBON_NEUTRAL':
                        $request->ShipmentRequest->Shipment->ShipmentServiceOptions->UPScarbonneutralIndicator = "";
                        break;
                    case 'UPS_ACSRL_DIRECT_DELIVERY_ONLY':
                        $request->ShipmentRequest->Shipment->ShipmentServiceOptions->DirectDeliveryOnlyIndicator = "";
                        break;
                    case 'UPS_ACSRL_DECLARED_VALUE':
                        break;
                    case 'UPS_ACSRL_SIGNATURE_REQUIRED':
                        if ($from_country != 'US' || $to_country != 'US') {
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation = new \stdClass();
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation->DCISType = "1";
                        }
                        break;
                    case 'UPS_ACSRL_ADULT_SIG_REQUIRED':
                        if ($from_country != 'US' || $to_country != 'US') {
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation = new \stdClass();
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->DeliveryConfirmation->DCISType = "2";
                        }
                        break;
                    case 'UPS_ACSRL_ACCESS_POINT_COD':
                        $currency_code = $data->invoice_line_total->currency_code;
                        $monetary_value = preg_replace($this->char_num, '', $data->invoice_line_total->monetary_value);
                        $request->ShipmentRequest->Shipment->ShipmentServiceOptions->AccessPointCOD = new \stdClass();
                        $request->ShipmentRequest->Shipment->ShipmentServiceOptions->AccessPointCOD->CurrencyCode = (string)$currency_code;
                        $request->ShipmentRequest->Shipment->ShipmentServiceOptions->AccessPointCOD->MonetaryValue = (string)$monetary_value;
                        break;
                    case 'UPS_ACSRL_TO_HOME_COD':
                        if (!in_array(strtolower($to_country), ['us', 'ca', 'mx', 'pr'])) {
                            $currency_code = $data->invoice_line_total->currency_code;
                            $monetary_value = preg_replace($this->char_num, '', $data->invoice_line_total->monetary_value);
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->COD = new \stdClass();
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->COD->CODFundsCode = "1";
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->COD->CODAmount = new \stdClass();
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->COD->CODAmount->CurrencyCode = (string)$currency_code;
                            $request->ShipmentRequest->Shipment->ShipmentServiceOptions->COD->CODAmount->MonetaryValue = (string)$monetary_value;
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * Set notification
     *
     * @param object $data //data input
     * @param array $notification //notification info
     * @param string $notificationCode //notification code
     */
    public function setNotification($data, &$notification, $notificationCode)
    {
        $notify = new \stdClass();
        $notify->NotificationCode = $notificationCode;
        $notify->EMail = new \stdClass();
        $notify->EMail->EMailAddress = $data->shipto->email;
        $notify->Locale = new \stdClass();
        $localInfo = $this->getNotificationLocale($data->shipto->country_code);
        $notify->Locale->Language = $localInfo['Language'];
        $notify->Locale->Dialect = $localInfo['Dialect'];
        $notification[] = $notify;
    }

    /**
     * Get notification locale by country code
     *
     * @param string $countryCode //The country code
     */
    public function getNotificationLocale($countryCode)
    {
        $locale = [
            'CZ' => [
                'Language' => "CES",
                'Dialect' => "97"
            ],
            'DK' => [
                'Language' => "DAN",
                'Dialect' => "97"
            ],
            'DE' => [
                'Language' => "DEU",
                'Dialect' => "97"
            ],
            'GR' => [
                'Language' => "ELL",
                'Dialect' => "97"
            ],
            'EN' => [
                'Language' => "ENG",
                'Dialect' => "GB"
            ],
            'FI' => [
                'Language' => "FIN",
                'Dialect' => "97"
            ],
            'FR' => [
                'Language' => "FRA",
                'Dialect' => "97"
            ],
            'BE' => [
                'Language' => "FRA",
                'Dialect' => "97"
            ],
            'HU' => [
                'Language' => "HUN",
                'Dialect' => "97"
            ],
            'IT' => [
                'Language' => "ITA",
                'Dialect' => "97"
            ],
            'NL' => [
                'Language' => "NLD",
                'Dialect' => "97"
            ],
            'NO' => [
                'Language' => "NOR",
                'Dialect' => "97"
            ],
            'PL' => [
                'Language' => "POL",
                'Dialect' => "97"
            ],
            'RO' => [
                'Language' => "RON",
                'Dialect' => "RO"
            ],
            'RU' => [
                'Language' => "RUS",
                'Dialect' => "97"
            ],
            'SK' => [
                'Language' => "SLK",
                'Dialect' => "97"
            ],
            'ES' => [
                'Language' => "SPA",
                'Dialect' => "97"
            ],
            'SE' => [
                'Language' => "SWE",
                'Dialect' => "97"
            ],
            'TR' => [
                'Language' => "TUR",
                'Dialect' => "97"
            ]
        ];
        if (array_key_exists($countryCode, $locale)) {
            return $locale[$countryCode];
        } else {
            return [
                'Language' => "ENG",
                'Dialect' => "GB"
            ];
        }
    }
}
