import {Component, OnInit} from '@angular/core';
import {NavController, NavParams, AlertController, ViewController} from 'ionic-angular';
import {ConnexionPage} from "../connexion/connexion";
import {AccueilPage} from "../accueil/accueil";
import {UserService} from "../../app/services/user.service";
import {AccountService} from "../../app/services/account.service";

/*
  Generated class for the Profil page.

  See http://ionicframework.com/docs/v2/components/#navigation for more info on
  Ionic pages and navigation.
*/
@Component({
  selector: 'page-profil',
  templateUrl: 'profil.html'
})
export class ProfilPage implements OnInit {

  username;
  email;
  password;
  sexe;
  descriptions: any = [];


  /**
   *
   * @param alertCtrl
   * @param nav
   * @param navPar
   */
  constructor(public alertCtrl: AlertController,public viewCtrl: ViewController, public account: AccountService, public nav: NavController, public navPar: NavParams, public user: UserService) {}

  ngAfterViewInit(){}
  ionViewDidLoad(){}

  /**
   * Initialisation :
   */
  ngOnInit(){
    this.loadUserProfil();
  }

  /**
   *
   */
  loadUserProfil(){

    this.account.getAccount().then((data) => {

      this.username = data['username'];
      this.email = data['email'];
      this.descriptions = data['descriptions'];
      console.log("", data)

      data['descriptions'].forEach((f) => {

        if(f.gender == "Male"){
          this.sexe = "Mr";
        } else {
          this.sexe = "Mme";
        }

      });

    });

  }

  /**
   *
   */
  changeUsername() {
    let alert = this.alertCtrl.create({
      title: 'Modifier le nom',
      buttons: [
        'Annuler'
      ]
    });
    alert.addInput({
      name: 'username',
      value: this.username,
      placeholder: 'username'
    });
    alert.addButton({
      text: 'Confirmer',
      handler: data => {
        this.updateUsername(data.username);
      }
    });

    alert.present();
  }

  updateUsername(user) {
    /*
    this.account.update(user).then((username) => {
      this.username = username;
    }); */
  }

  /**
   *
   */
  changePassword() {
    console.log('Clicked to change password');
    let alert = this.alertCtrl.create({
      title: 'Mot de passe',
      buttons: [
        'Annnuler'
      ]
    });
    alert.addInput({
      name: 'Ancien mot de passe',
      value: this.password,
      placeholder: 'Ancien mot de passe'
    });
    alert.addInput({
      name: 'Nouveaux mot de passe',
      value: this.password,
      placeholder: 'Nouveau mot de passe'
    });
    alert.addInput({
      name: 'Confirmer nouveaux mot de passe',
      value: this.password,
      placeholder: 'Confirmer mot de passe'
    });
    alert.addButton({
      text: 'Confirmer',
      handler: data => {}
    });

    alert.present();
  }

  deleteProfil(){

    let alert = this.alertCtrl.create({
      title: "Attention!",
      message: 'Voulez-vous supprimez votre compte?',
      buttons: [
        {
          text: 'Annuler',
          handler: () => {
            // they clicked the cancel button, do not remove the account
          }
        },
        {
          text: 'Supprimer',
          handler: () => {
            // they want to remove this account
            //this.account.remove();

          }
        }
      ]
    });
    // now present the alert on top of all other content
    alert.present();
  }


  /**
   *
   */
  close(){
    this.nav.setRoot(AccueilPage, {}, {animate: true, direction: 'back'});
  }

  /**
   *
   */
  logout() {
    //this.userData.logout();
    this.nav.setRoot(ConnexionPage);
  }

}
