import { Component, ViewChild } from '@angular/core';

import {Platform, MenuController, Nav} from 'ionic-angular';

import { StatusBar, Splashscreen } from 'ionic-native';
import {ConnexionPage} from "../pages/connexion/connexion";
import {SettingPage} from "../pages/setting/setting";
import {AccueilPage} from "../pages/accueil/accueil";
import {ScanPage} from "../pages/scan/scan";
import {ScanResultPage} from "../pages/scan-result/scan-result";
import {OAuthService} from "angular-oauth2-oidc";
import {ProfilPage} from "../pages/profil/profil";
import {ConnexionProvider} from "../providers/connexion-provider";
import {NotificationsPage} from "../pages/notifications/notifications";
import {HelpPage} from "../pages/help/help";

export interface PageInterface {
  title: string;
  component: any;
  icon: string;
  logsOut?: boolean;
  index?: number;
}

@Component({
  templateUrl: 'app.html'
})
export class MyApp {

  @ViewChild(Nav) nav: Nav;

  // make HelloIonicPage the root (or first) page
  // List of pages that can be navigated to from the left menu
  // the left menu only works after login
  // the login page disables the left menu

  loggedInPages: PageInterface[] = [
    { title: 'Accueil', component: AccueilPage, icon: 'home' },
    { title: 'Profil', component: ProfilPage, icon: 'person' },
    { title: 'Paramètre', component: SettingPage,  icon: 'settings'  },
    { title: 'Notifications', component: NotificationsPage, icon: 'notifications'},
    { title: 'Scanneur Qr Code', component: ScanPage, icon: 'qr-scanner'},
    { title: 'Result Scan', component: ScanResultPage, icon: 'barcode'},
    { title: 'Déconnexion', component: AccueilPage, icon: 'log-out', logsOut: true },
    { title: 'Aide et Commentaires', component: HelpPage,  icon: 'information-circle'  },
  ];

  rootPage: any = ConnexionPage;

  constructor(
    public platform: Platform,
    public menu: MenuController,
    private oauthService: OAuthService,
    public auth: ConnexionProvider
  ) {
    this.initializeApp();

    // set our app's pages
  }

  initializeApp() {

    // Call any initial plugins when ready
    this.platform.ready().then(() => {
      // Okay, so the platform is ready and our plugins are available.
      // Here you can do any higher level native things you might need.
      StatusBar.styleDefault();
      Splashscreen.hide();
    });

    this.oauthConfiguration();

  }

  oauthConfiguration(){

    //TODO oauth configuration

    // Token Endpoint
    this.oauthService.tokenEndpoint = "http://localhost:8000/app_dev.php/oauth/v2/token";

    // URL of the SPA to redirect the user to after login
    this.oauthService.redirectUri = window.location.origin + "/";

    // The SPA's id. Register SPA with this id at the auth-server
    this.oauthService.clientId = "1_X8W5ePRb98ThJyXZXwH7bH7Lk4xtpYj5Q3ARX6qKzQKXXwGrpe";

    // Set a dummy secret
    this.oauthService.dummyClientSecret = "dKtuFQTXCmd99B6BgvJc3CD74oKLmdJNQz29zthrPz2JXyrYt2";

    // set to true, to receive also an id_token via OpenId Connect (OIDC) in addition to the
    // OAuth2-based access_token
    this.oauthService.oidc = true;

    // Use setStorage to use sessionStorage or another implementation of the TS-type Storage
    // instead of localStoragenavCtrl
    this.oauthService.setStorage(sessionStorage);

  }

  /*
  check(){

    if(this.oauthService.hasValidAccessToken() == false){
      this.rootPage;
      console.log("invalid")
    } else {
      console.log("valid")
    }
  } */



  openPage(page: PageInterface) {
    // the nav component was found using @ViewChild(Nav)
    // reset the nav to remove previous pages and only have this page
    // we wouldn't want the back button to show in this scenario

    this.nav.setRoot(page.component);

    if (page.logsOut === true) {
      // Give the menu time to close before changing to logged out
      setTimeout(() => {
        // TODO
        this.menu.close();
        this.auth.logout();
        this.nav.setRoot(ConnexionPage);
      }, 1000);
    }
  }
}
