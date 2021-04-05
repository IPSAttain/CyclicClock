<?php

declare(strict_types=1);
	class CyclicClock extends IPSModule
	{
		public function Create()
		{
			//Never delete this line!
			parent::Create();
			$this->RegisterTimer("Update", 5000, "ATN_InvertBool($this->InstanceID);");
		}

		public function Destroy()
		{
			//Never delete this line!
			parent::Destroy();
		}

		public function ApplyChanges()
		{
			//Never delete this line!
			parent::ApplyChanges();
			$Ident = 'ATN_Cyclic_Clock';
			$this->RegisterVariableBoolean($Ident, $this->Translate('Cyclic Clock'), '~Switch', 10);
			$this->RegisterVariableBoolean($Ident.'_Activ', $this->Translate('Active'), '~Switch', 20);
			$this->EnableAction($Ident.'_Activ');
			
			if (!IPS_VariableProfileExists('ATN.Throughput.ppm')) {
				IPS_CreateVariableProfile('ATN.Throughput.ppm', 1);
				IPS_SetVariableProfileIcon('ATN.Throughput.ppm', 'TurnLeft');
				IPS_SetVariableProfileText('ATN.Throughput.ppm', '', ' PPM');
				IPS_SetVariableProfileValues('ATN.Throughput.ppm', 10, 300, 10);
			}
			$this->RegisterVariableInteger($Ident.'_Throughput_PPM', $this->Translate('Cycles per Minute'), 'ATN.Throughput.ppm', 30);
			$this->EnableAction($Ident.'_Throughput_PPM');

			if (!IPS_VariableProfileExists('ATN.Throughput.pph')) {
				IPS_CreateVariableProfile('ATN.Throughput.pph', 1);
				IPS_SetVariableProfileIcon('ATN.Throughput.pph', 'TurnLeft');
				IPS_SetVariableProfileText('ATN.Throughput.pph', '', ' PPH');
				IPS_SetVariableProfileValues('ATN.Throughput.pph', 100, 30000, 100);
			}
			$this->RegisterVariableInteger($Ident.'_Throughput_PPH', $this->Translate('Cycles per Hour'), 'ATN.Throughput.pph', 40);
			$this->EnableAction($Ident.'_Throughput_PPH');

		}

		public function InvertBool()
		{
			$Ident = 'ATN_Cyclic_Clock';
			$this->SendDebug(__FUNCTION__,$_IPS['SENDER'] ,0);
			if ($this->GetValue('ATN_Cyclic_Clock_Activ') && $_IPS['SENDER'] == "TimerEvent")
			{
				$this->RegisterVariableBoolean($Ident, $this->Translate('Cyclic Clock'), '~Switch', 10);
				$this->SetValue($Ident,!$this->GetValue($Ident));
			}
		}

		public function RequestAction($Ident, $Value)
		{
			$this->SetValue($Ident,$Value);
			$this->SendDebug(__FUNCTION__,$_IPS['SENDER'] . ' | Ident: ' . $Ident . ' | Value: ' . $Value,0);
			switch ($Ident) {
				case 'ATN_Cyclic_Clock_Throughput_PPM':
					if ($this->GetValue('ATN_Cyclic_Clock_Activ'))
					{
						$this->SetTimerInterval("Update", 60/$Value*500);
					}
					$this->SetValue('ATN_Cyclic_Clock_Throughput_PPH',$Value*60);
					break;

				case 'ATN_Cyclic_Clock_Throughput_PPH':
					if ($this->GetValue('ATN_Cyclic_Clock_Activ'))
					{
						$this->SetTimerInterval("Update", 60*60/$Value*500);
					}
					$this->SetValue('ATN_Cyclic_Clock_Throughput_PPM',$Value/60);
					break;

				case 'ATN_Cyclic_Clock_Activ':
					if(!$Value) 
					{
						$this->SetTimerInterval("Update", 0);
					}
					else
					{
						$PPM = $this->GetValue('ATN_Cyclic_Clock_Throughput_PPM');
						if (!$PPM) $PPM = 10;
						$this->SetTimerInterval("Update", 60 / $PPM * 500);
					}
					break;
			}
		}
	}