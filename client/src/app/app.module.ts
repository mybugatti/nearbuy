import {NgModule, ErrorHandler, CUSTOM_ELEMENTS_SCHEMA} from '@angular/core';
import { IonicApp, IonicModule, IonicErrorHandler } from 'ionic-angular';
import { MyApp } from './app.component';
import {ConnexionPage} from "../pages/connexion/connexion";
import {ConnexionProvider} from "../providers/connexion-provider";
import {Storage} from "@ionic/storage";
import {InscriptionPage} from "../pages/inscription/inscription";
import {InscriptionProvider} from "../providers/inscription-provider";
import {AccueilPage} from "../pages/accueil/accueil";
import {MapProvider} from "../providers/map-provider";
import {IonPullupModule} from './ionic-pullup/ion-pullup.module';
import {PromotionDetailPagePage} from "../pages/promotion-detail-page/promotion-detail-page";
import {Map} from "../components/map/map";
import {EnterprisePage} from "../pages/enterprise/enterprise";
import {AboutPromotionPage} from "../pages/about-promotion/about-promotion";
import {AboutEnterprisePage} from "../pages/about-enterprise/about-enterprise";
import {ForgotPage} from "../pages/forgot/forgot";
import {SettingPage} from "../pages/setting/setting";
import {FilterPage} from "../pages/filter/filter";
import {FilterProvider} from "../providers/filter-provider";
import {OAuthModule} from "angular-oauth2-oidc";
import {ProfilPage} from "../pages/profil/profil";
import {ScanPage} from "../pages/scan/scan";
import {ScanResultPage} from "../pages/scan-result/scan-result";
import {ParallaxHeader} from "../components/parallax-header/parallax-header";
import {EnterpriseShopPage} from "../pages/enterprise-shop/enterprise-shop";
import {PromotionService} from "./services/promotion.service";
import {LocalService} from "./services/local.service";
import {UserService} from "./services/user.service";
import {EntrepriseService} from "./services/entreprise.service";
import {TimerPromotionPage} from "../pages/timer-promotion/timer-promotion";
import {CategoryService} from "./services/category.service";
import {RegisterService} from "./services/register.service";
import {HelpPage} from "../pages/help/help";
import {NotificationsPage} from "../pages/notifications/notifications";
import {AccountService} from "./services/account.service";
import {FavouriteService} from "./services/favourite.service";
import {FavouriteEntrepriseService} from "./services/favouriteEntreprise.service";

// Application wide providers
const APP_PROVIDERS = [
  ConnexionProvider,
  InscriptionProvider,
  MapProvider,
  FilterProvider,
  Storage,
  PromotionService,
  LocalService,
  UserService,
  EntrepriseService,
  CategoryService,
  AccountService,
  FavouriteService,
  FavouriteEntrepriseService,
  CategoryService,
  RegisterService
];

@NgModule({
  declarations: [
    MyApp,
    ConnexionPage,
    InscriptionPage,
    AccueilPage,
    PromotionDetailPagePage,
    EnterprisePage,
    Map,
    ParallaxHeader,
    AboutPromotionPage,
    AboutEnterprisePage,
    ForgotPage,
    ScanPage,
    ScanResultPage,
    SettingPage,
    ProfilPage,
    FilterPage,
    EnterpriseShopPage,
    HelpPage,
    NotificationsPage,
    TimerPromotionPage
  ],
  imports: [
    IonicModule.forRoot(MyApp),
    IonPullupModule,
    OAuthModule.forRoot()
  ],
  bootstrap: [IonicApp],
  entryComponents: [
    MyApp,
    ConnexionPage,
    InscriptionPage,
    AccueilPage,
    PromotionDetailPagePage,
    EnterprisePage,
    AboutPromotionPage,
    AboutEnterprisePage,
    ForgotPage,
    SettingPage,
    ScanPage,
    ScanResultPage,
    ProfilPage,
    FilterPage,
    EnterpriseShopPage,
    HelpPage,
    NotificationsPage,
    TimerPromotionPage
  ],
  providers: [{provide: ErrorHandler, useClass: IonicErrorHandler}, APP_PROVIDERS],
  schemas: [ CUSTOM_ELEMENTS_SCHEMA ]
})
export class AppModule {}
