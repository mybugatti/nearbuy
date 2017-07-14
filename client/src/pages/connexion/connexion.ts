import { Component } from '@angular/core';
import {NavController, NavParams, MenuController, LoadingController} from 'ionic-angular';
import {AbstractControl, FormGroup, Validators, FormBuilder} from "@angular/forms";
import {ConnexionProvider} from "../../providers/connexion-provider";
import {InscriptionPage} from "../inscription/inscription";
import {AccueilPage} from "../accueil/accueil";
import {ForgotPage} from "../forgot/forgot";
import {OAuthService} from "angular-oauth2-oidc";

/*
  Generated class for the Connexion page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-connexion',
  templateUrl: 'connexion.html'
})
export class ConnexionPage {

  /**
   * Déclaration Variables
   */
  username:AbstractControl;
  password: AbstractControl;
  loginForm:FormGroup;
  error:any;

  menu;
  loading:any;
  inscriptionPage:any;
  forgotPage:any;

  /**
   *
   * @param navCtrl
   * @param loadingCtrl
   * @param navParams
   * @param menu
   * @param fb
   * @param auth
   */
  constructor(public navCtrl: NavController,
              private oauthService: OAuthService,
              public loadingCtrl: LoadingController,
              public navParams: NavParams,
              menu: MenuController,
              private fb: FormBuilder,
              public auth: ConnexionProvider) {
    this.menu = menu; /* */
    this.menu.swipeEnable(false); /*  desactive le menuController de la page */

    /* Validator */
    this.loginForm = fb.group({
      'username': ['', Validators.compose([Validators.required])],
      'password': ['', Validators.compose([Validators.required])]
    });

    /* Controls username & password */
    this.username = this.loginForm.controls['username'];
    this.password = this.loginForm.controls['password'];

    this.inscriptionPage = InscriptionPage;
    this.forgotPage = ForgotPage;
  }

  ionViewDidLoad() {

    this.checkAuthentification();

  }

  /**
   * Function: Connexion automatique si le user est déjà loggé
   */
  checkAuthentification(){
    this.showLoader();
    //Check if already authenticated
    if(this.oauthService.hasValidAccessToken()) {
      console.log("Already authorized");
      this.loading.dismiss();
      this.navCtrl.setRoot(AccueilPage);
    } else {
      console.log("Not already authorized");
      this.loading.dismiss();
    }
  }
  /**
   * Function : Authentification User
   * (permets à l'utilisateur de se connecter avec ses identifiants)
   * @param form
   */
  onSubmit(value: string): void {

    this.showLoader(); // show loader

    //TODO: connection to api oauth
    /**
     * Si le login et password sont valides :
     */
    if(this.loginForm.valid) {

      // traitement
      this.oauthService
        .fetchTokenUsingPasswordFlow(value['username'],value['password'])
        .then((resp) => {
          this.loading.dismiss();
          this.navCtrl.setRoot(AccueilPage);
        })
        .catch((err) => {
          this.error = err._body;
          this.setError(this.error);
          this.loading.dismiss();
        });

    } else {
      // erreur
      this.loading.dismiss(); // hide loader
    }

  } // fin function

  setError(error){
    this.error = error;
  }

  getError(){
    return this.error;
  }

  /**
   * Function :
   * Loading...
   */
  showLoader(){

    this.loading = this.loadingCtrl.create({
      content: ' Connexion en cours...'
    });

    this.loading.present();
  }

}
