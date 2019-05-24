<?

class SymBoxAntenne extends IPSModule {

private $Host = "";

public function Create(){
  //Never delete this line!
  parent::Create();

  //These lines are parsed on Symcon Startup or Instance creation
  //You cannot use variables here. Just static values.


}



public function Destroy(){
  //Never delete this line!
  parent::Destroy();
}



public function ApplyChanges(){
  //Never delete this line!
  parent::ApplyChanges();

}

public function ReceiveData($JSONString) {

    // Empfangene Daten vom I/O
    $data = json_decode($JSONString);
    IPS_LogMessage("ReceiveData", utf8_decode($data->Buffer));

    // Hier werden die Daten verarbeitet

    // Weiterleitung zu allen Gerät-/Device-Instanzen
    $this->SendDataToChildren(json_encode(Array("DataID" => "{8461A6B8-8FC3-5E4D-CFA3-6D3C23F9A547}", "Buffer" => $data->Buffer)));
}

public function ForwardData($JSONString) {

    // Empfangene Daten von der Device Instanz
    $data = json_decode($JSONString);
    IPS_LogMessage("ForwardData", utf8_decode($data));

    $resultat = $this->SendDataToParent(json_encode(Array("DataID" => "{018EF6B5-AB94-40C6-AA53-46943E824ACF}", "Buffer" => $data->Buffer)));

    return $resultat;
}

}

?>
