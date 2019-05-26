<?
    // Klassendefinition
class SymAnRohdaten extends IPSModule {

        // Der Konstruktor des Moduls
        // Überschreibt den Standard Kontruktor von IPS
        public function __construct($InstanceID) {
            // Diese Zeile nicht löschen
            parent::__construct($InstanceID);

	    // Selbsterstellter Code



        }

        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
		parent::Create();

		$this->RegisterVariableString("eGate", "eGate Werte", "", "0");
		$this->RegisterVariableBoolean("Command", "Befehl", "~Switch", "0");
		$this->EnableAction("Command");

		$this->RegisterPropertyString("Adresse", "");


        }

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }

        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
        public function MeineErsteEigeneFunktion() {
            // Selbsterstellter Code
        }


	public function ReceiveData($JSONString) {

	    // Empfangene Daten vom Gateway/Splitter
	    $data = json_decode($JSONString);

	    // Datenverarbeitung und schreiben der Werte in die Statusvariablen
		SetValue($this->GetIDForIdent("eGate"), bin2hex(print_r($data->Buffer, true)));

	}
	
	public function BefehlTest() {

			$Value = GetValue($this->GetIDForIdent("Command"));

			switch($Value)
			{
				case true:
					
					$FSSBefehl = hex2bin("01" . $this->ReadPropertyString("Adresse") . "0000" . "05");
					SetValue($this->GetIDForIdent("eGate"), bin2hex($FSSBefehl));
					return $this->SendDataToParent(json_encode(Array("DataID" => "{79827379-F36E-4ADA-8A95-5F8D1DC92FA9}", "Buffer" => $FSSBefehl)));	
				break;
			}
	
	
	
	}

	
	public function RequestAction($Ident, $Value) {

		switch($Ident) {
        	case "Command":
				//Neuen Wert in die Statusvariable schreiben
					SetValue($this->GetIDForIdent($Ident), $Value);
					$this->BefehlTest();	
			break;
			case "lowerValueSun":
				//Neuen Wert in die Statusvariable schreiben
				SetValue($this->GetIDForIdent($Ident), $Value);
			break;
			case "upperValueWind":
				//Neuen Wert in die Statusvariable schreiben
				SetValue($this->GetIDForIdent($Ident), $Value);
			break;
			case "lowerValueWind":
				//Neuen Wert in die Statusvariable schreiben
				SetValue($this->GetIDForIdent($Ident), $Value);
			break;
			case "StateChangeSun":
				//Neuen Wert in die Statusvariable schreiben
				SetValue($this->GetIDForIdent($Ident), $Value);
				$this->BeschattungAktivDeaktiv();
			break;
			}

    }

    }


?>
