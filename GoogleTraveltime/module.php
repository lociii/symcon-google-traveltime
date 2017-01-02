<?php

include_once(__DIR__ . '/../shared/BaseModule.php');

class GoogleTraveltime extends IPSBaseModule
{
    protected $config = array('gt_api_key', 'gt_origin', 'gt_destination', 'gt_interval');

    public function Create()
    {
        parent::Create();

        $this->RegisterPropertyString('gt_api_key', '');
        $this->RegisterPropertyString('gt_origin', '');
        $this->RegisterPropertyString('gt_destination', '');
        $this->RegisterPropertyInteger('gt_interval', 5);

        if (!IPS_VariableProfileExists('LOCI.Minutes')) {
            IPS_CreateVariableProfile('LOCI.Minutes', 1);
        }

        $this->RegisterTimer('update', $this->ReadPropertyInteger('gt_interval'), 'LOCIGT_Update($_IPS[\'TARGET\']);');
    }

    protected function OnConfigValid()
    {
        $this->SetTimerInterval('update', $this->ReadPropertyInteger('gt_interval') * 1000 * 60);
        $this->MaintainVariable('duration', 'Duration', 1, 'LOCI.Minutes', 10, true);
        $this->MaintainVariable('delay', 'Delay', 1, 'LOCI.Minutes', 20, true);
        $this->SetStatus(102);
    }

    protected function OnConfigInvalid()
    {
        $this->SetTimerInterval('update', 0);
        $this->SetStatus(104);
    }

    public function Update()
    {
        $api_key = $this->ReadPropertyString('gt_api_key');
        $origin = urlencode($this->ReadPropertyString('gt_origin'));
        $destination = urlencode($this->ReadPropertyString('gt_destination'));

        $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins=' . $origin .
            '&destinations=' . $destination . '&mode=driving&language=de-DE&departure_time=now&key=' . $api_key;
        $data = json_decode(file_get_contents($url));

        $usual_time = ceil($data->rows[0]->elements[0]->duration->value / 60);
        $traffic_time = ceil($data->rows[0]->elements[0]->duration_in_traffic->value / 60);

        SetValue($this->GetIDForIdent('duration'), $traffic_time);
        SetValue($this->GetIDForIdent('delay'), $traffic_time - $usual_time);
    }
}
