<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Service\NavbarFactory;

use App\Controller\AccountManagementController;
use App\Entity\User;
use App\Query\GetNewMessageCountQuery;
use App\Service\NavbarService;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Description of AccountMngmtNavbarFactory
 *
 * @author Matthias
 */
class AccountMngmtNavbarFactory {

    /**
     *
     * @var NavbarService
     */
    private $navbarService;

    /**
     *
     * @var EntityManagerInterface
     */
    private $eManager;

    function __construct(NavbarService $navbarService, EntityManagerInterface $eManager) {
        $this->navbarService = $navbarService;
        $this->eManager = $eManager;
    }

    public function buildNavbar(User $account) {
        $builder = $this->navbarService;
        if ($account->isBanned() || !$account->getValidated()) {
            $this->addBannedNavs();
        } else {
            $this->addStandardNavs();
            $this->addModNavs($account);
        }
//        $builder->addNavhead('Sonstiges')
//                ->addNav('Karte', 'map')
//                ->addNav('Regeln', 'rules')
//                ->addNav('Kämpferliste', 'list')
//                ->addPopupLink('Discord', 'https://discord.gg/Yu8tYxF')
//                ->addPopupLink('Wiki', 'http://www.rhun-logd.de/wiki')
//                ->addNavhead('Abmelden')
//                ->addNav('Abmelden', 'account_logout', []);
        return $builder;
    }

    private function addBannedNavs() {
        $this->navbarService
                ->addNav('Bio Editor (gesperrt)', AccountManagementController::ACCOUNT_MANAGEMENT_ROUTE_NAME)
                ->addNav('Tagebuch schreiben (gesperrt)', AccountManagementController::ACCOUNT_MANAGEMENT_ROUTE_NAME)
                ->addNav('Taubenschlag (gesperrt)', AccountManagementController::ACCOUNT_MANAGEMENT_ROUTE_NAME);
    }

    private function addStandardNavs() {
        $query = new GetNewMessageCountQuery($this->eManager);
        $count = $query();

//        $this->navbarService
//                ->addNav('Bio Editor', 'bioEditor')
//                ->addNav('Tagebuch schreiben', 'diary_editor')
//                ->addNav('Taubenschlag' . ($count > 0 ? ' (Neu: ' . $count . ')' : ''), 'mail_show');
    }

    private function addModNavs(User $account) {
//        $builder = $this->navbarService;
//        if ($account->getUserRole()->getWriteMotd()) {
//            $builder->addNavhead('Motd')
//                    ->addNav('Motd-Creator', 'motd_editor', []);
//        }
//        if ($account->getUserRole()->getEditWorld()) {
//            $builder->addNav('Einstellungen', 'settingsEditor');
//        }
//        if ($account->getUserRole()->getEditMonster()) {
//            $builder->addNavhead('Editoren')
//                    ->addNav('Monster', 'admin_monster', [])
//                    ->addNav('Aktivitäten', 'admin_activity', []);
//        }
//        if ($account->getUserRole()->getReviewPosts()) {
//            $builder->addNavhead('Mod')
//                    ->addNav('Postübersicht', 'post-list');
//        }
    }

}