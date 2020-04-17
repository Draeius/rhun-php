<?php

namespace App\Service\NavbarFactory;

use App\Controller\AccountManagementController;
use App\Controller\ListController;
use App\Controller\WorldController;
use App\Doctrine\UuidEncoder;
use App\Entity\Character;
use App\Entity\ServerSettings;
use App\Repository\CharacterRepository;
use App\Service\NavbarService;
use App\Util\Session\RhunSession;
use App\Util\TabIdentification\TabIdentifier;

/**
 * Description of BiographyNavbarGenerator
 *
 * @author Draeius
 */
class BiographyNavbarGenerator {

    /**
     *
     * @var NavbarService
     */
    private $navbarService;

    function __construct(NavbarService $navbarService) {
        $this->navbarService = $navbarService;
    }

    public function getStandardNavbar(TabIdentifier $tabIdentifier, Character $char) {
        $this->navbarService->addNav('Zurück', WorldController::STANDARD_WORLD_ROUTE_NAME, [
            'uuid' => $tabIdentifier->getIdentifier(),
            'locationId' => $char->getLocation()->getId()]);
        return $this->navbarService;
    }

    public function getBiographyNavbar(Character $character, CharacterRepository $charRepo, ServerSettings $settings) {
        $builder = $this->navbarService;
        $session = new RhunSession();
        if ($session->getTabIdentifier()->hasIdentifier()) {
            $location = $charRepo->find($session->getCharacterID())->getLocation();
            $encoder = new UuidEncoder();
            $builder->addNav('Zurück zur Kämpferliste', ListController::CHAR_LIST_ROUTE_NAME, [
                'uuid' => $session->getTabIdentifier()->getIdentifier()
            ]);
            $builder->addNav('Zurück', WorldController::STANDARD_WORLD_ROUTE_NAME, [
                'uuid' => $session->getTabIdentifier()->getIdentifier(),
                'locationId' => $encoder->encode($location->getUuid())
            ]);
        } else {
            $builder->addNav('Zurück zur Kämpferliste', ListController::CHAR_LIST_ROUTE_NAME);
            $builder->addNav('Zurück zur Charakterübersicht', AccountManagementController::ACCOUNT_MANAGEMENT_ROUTE_NAME);
        }

        $entries = $character->getDiaryEntries();
        if (sizeof($entries) > 0 && !$settings->getUseMaskedBios()) {
            $builder->addNavhead('Tagebucheinträge');
            foreach ($entries as $diaryEntry) {
                $builder->addNav($diaryEntry->getTitle(), 'diary_show', [
                    'charId' => $character->getId(),
                    'diaryId' => $diaryEntry->getId(),
                    'uuid' => $session->getTabIdentifier()->getIdentifier()]);
            }
        }
    }

    public function getEditorNavbar() {
        $this->navbarService->addNav('Zurück', AccountManagementController::ACCOUNT_MANAGEMENT_ROUTE_NAME);
        return $this->navbarService;
    }

}