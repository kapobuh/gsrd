<?php
class ControllerCommonFunctions extends Controller {
    /**
     * Возвращает список Поиско-спасательных подразделений,
     * @return bool
     */
    public function getSeloByDistrict()
    {
        $this->load->model('common/helpers');

        if (!isset($this->request->get['district_id'])) {
            return false;
        }

        $sela = $this->model_common_helpers->getSeloByDistrict($this->request->get['district_id']);

        if ($sela) {
            foreach ($sela as $selo) {
                $result[] = array(
                    'selo_id' => $selo['selo_id'],
                    'name' => $selo['name']
                );
            }
            $this->response->addHeader('Content-Type: application/json');
            $this->response->setOutput(json_encode($result));

        } else {
            return false;
        }
    }

}
