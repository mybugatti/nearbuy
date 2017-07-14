import { Component } from '@angular/core';
import {NavController, NavParams, AlertController} from 'ionic-angular';
import {ConnexionPage} from "../connexion/connexion";
import {AccueilPage} from "../accueil/accueil";

/*
  Generated class for the Setting page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-setting',
  templateUrl: 'setting.html'
})
export class SettingPage {

  distance: number = 20;

  /**
   *
   * @param alertCtrl
   * @param nav
   * @param navPar
   */
  constructor(public alertCtrl: AlertController, public nav: NavController, public navPar: NavParams) {}

  ngAfterViewInit() {}

  updatePicture() {
    console.log('Clicked to update picture');
  }


  close(){
    //this.nav.setRoot(AccueilPage);
    this.nav.setRoot(AccueilPage, {}, {animate: true, direction: 'forward'});
  }

  /**
   *
   */
  logout() {
    //this.userData.logout();
    this.nav.setRoot(ConnexionPage);
  }
}
