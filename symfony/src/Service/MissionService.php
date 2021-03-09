<?php

namespace App\Service;

use App\Repository\MissionRepository;
use Symfony\Component\Intl\Languages;

class MissionService
{
    private $missionRepository;

    public function __construct(MissionRepository $missionRepository)
    {
        $this->missionRepository = $missionRepository;
    }

    /**
     * Finds all missions
     */
    public function getMissionsListforDataTable(int $offset, int $limit, string $search, string $sort, string $order, string $status, string $country, string $type): array
    {
        $total = $this->missionRepository->countMissionsList($search, $status, $country, $type);

        $result['total'] = $total;
        $result['totalNotFiltered'] = $total;
        $result['rows'] = [];
        $missions = $this->missionRepository->findMissionsList($offset, $limit, $search, $sort, $order, $status, $country, $type);
        foreach ($missions as $mission) {
            $result['rows'][] = [
                'idmission' => $mission->getIdMission(),
                'title' => $mission->getTitle(),
                'code' => $mission->getCode(),
                'country' => $mission->getCountry(),
                'type' => $mission->getType()->getName(),
                'status' => $mission->getStatus(),
                'start' => $mission->getStart()->format('d/m/Y'),
                'end' => $mission->getEnd()->format('d/m/Y')
            ];
        }
        return $result;
    }

    /**
     * Finds details of a mission
     */
    public function getMissionDetails($idmission): array
    {
        $mission = $this->missionRepository->find($idmission);

        // Mission details
        $result = [
            'idmission' => $mission->getIdMission(),
            'title' => $mission->getTitle(),
            'description' => $mission->getDescription(),
            'code' => $mission->getCode(),
            'country' => $mission->getCountry(),
            'type' => $mission->getType()->getName(),
            'speciality' => $mission->getSpec()->getName(),
            'status' => $mission->getStatus(),
            'start' => (!is_null($mission->getStart())) ? $mission->getStart()->format('d/m/Y H:i') : null,
            'end' => (!is_null($mission->getEnd())) ? $mission->getEnd()->format('d/m/Y H:i') : null
        ];

        // Hideouts details
        foreach ($mission->getIdHideout() as $hideout) {
            $result['hideout'][$hideout->getIdHideout()] = [
                'code' => $hideout->getCode(),
                'country' => $hideout->getCountry(),
                'address' => $hideout->getAddress(),
                'city' => $hideout->getCity(),
                'postcode' => $hideout->getPostcode(),
                'type' => $hideout->getType()->getName()
            ];
        }

        // Affected user
        foreach ($mission->getAffected() as $user) {
            $result['user'][$user->getIdUser()] = [
                'code' => $user->getCode(),
                'type' => $user->getType(),
                'name' => $user->getNom(),
                'firstname' => $user->getPrenom(),
                'born' => (!is_null($user->getBorn())) ? $user->getBorn()->format('d/m/Y') : null,
                'nationality' => $user->getNationality()
            ];

            foreach($user->getInSpeciality() as $speciality) {
                $result['user'][$user->getIdUser()]['speciality'][$speciality->getIdSpec()] = $speciality->getName();
            }
        }

        return $result;
    }

    /**
     * @return array return the text formatted list of available missions status
     */
    public function getStatusValues(): array
    {
        $resultStatus = [];
        $missionStatusValues = $this->missionRepository->findStatusValues();

        foreach($missionStatusValues as $stat) {
            $statusKey = $stat['status'];
            $resultStatus[$statusKey] = MissionService::getTextStatus($statusKey);
        }

        return $resultStatus;
    }

    /**
     * @param $status
     * @return string convert the status value to status text
     */
    public static function getTextStatus($status)
    {
        $formattedStatus = "";

        switch ($status) {
            case 'inpreparation' :
                $formattedStatus = 'In preparation';
                break;
            case 'inprogress' :
                $formattedStatus = 'In progress';
                break;
            case 'completed' :
                $formattedStatus = 'Completed';
                break;
            case 'failed' :
                $formattedStatus = 'Failed';
                break;
        }

        return $formattedStatus;
    }

    /**
     * @return array return the text formatted list of available country status
     */
    public function getCountryValues(): array
    {
        $resultCountries = [];
        $missionCountryValues = $this->missionRepository->findCountryValues();

        foreach($missionCountryValues as $country) {
            $countryKey = $country['country'];
            $resultCountries[$countryKey] = Languages::getName(strtolower($countryKey));
        }

        return $resultCountries;
    }
}