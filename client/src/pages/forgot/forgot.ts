import {Component, OnInit} from '@angular/core';
import {NavController, NavParams, LoadingController, MenuController} from 'ionic-angular';
import {FormBuilder, Validators, AbstractControl, FormGroup} from "@angular/forms";
import {InscriptionProvider} from "../../providers/inscription-provider";

/*
 Generated class for the Forgot page.

 See http://ionicframework.com/docs/v2/components/#navigation for more info on
 Ionic pages and navigation.
 */
@Component({
  selector: 'page-forgot',
  templateUrl: 'forgot.html'
})
export class ForgotPage implements OnInit {

  /**
   * Déclaration Variables
   */
  email: AbstractControl;
  forgotForm: FormGroup;

  menu;
  loading: any;

  constructor(public navCtrl: NavController, public loadingCtrl: LoadingController, menu: MenuController, private fb: FormBuilder, public navParams: NavParams,  public validator: InscriptionProvider) {
  }

  ionViewDidLoad() {
    console.log('ionViewDidLoad ForgotPage');
  }


  ngOnInit() {
    //called after the constructor and called  after the first ngOnChanges()

    /* Validator */
    this.forgotForm = this.fb.group({
      'email': ['', Validators.compose([Validators.required, Validators.pattern(this.validator.regexEmail())])]
    });

    /**
     * Controls
     * @type {AbstractControl}
     */
    this.email = this.forgotForm.controls['email'];
    console.log("email=>",this.email);
  }

  /**
   *
   * @param value
   */
  onSubmit(value: string): void {

    this.showLoader(); // show loader
    let credentials = {
      email: value['email']
    };

    if (this.forgotForm.valid) {

      console.log(credentials);
      // Traitement
      this.loading.dismiss();

    }

  }

  /**
   * Function :
   * Loading...
   */
  showLoader() {

    this.loading = this.loadingCtrl.create({
      content: ' Envoi en cours...'
    });

    this.loading.present();
  }


}
