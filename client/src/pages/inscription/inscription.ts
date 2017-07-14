import {Component, OnInit} from '@angular/core';
import {NavController, NavParams, LoadingController, MenuController} from 'ionic-angular';
import {AbstractControl, FormGroup, FormBuilder, Validators} from "@angular/forms";
import {InscriptionProvider} from "../../providers/inscription-provider";
import {RegisterService} from "../../app/services/register.service";
import {AccueilPage} from "../accueil/accueil";
import {OAuthService} from "angular-oauth2-oidc";

/*
 Generated class for the Inscription page.

 See http://ionicframework.com/docs/v2/components/#navigation for more info on
 Ionic pages and navigation.
 */
@Component({
    selector: 'page-inscription',
    templateUrl: 'inscription.html'
})
export class InscriptionPage implements OnInit {

    /**
     * Déclaration Variables
     */
    username: AbstractControl;
    firstname: AbstractControl;
    lastname: AbstractControl;
    role: AbstractControl;
    passwordGroup: AbstractControl;
    email: AbstractControl;
    signForm: FormGroup;
    error:any;

    menu;
    loading: any;

    /**
     *
     * @param navCtrl
     * @param loadingCtrl
     * @param menu
     * @param fb
     * @param navParams
     * @param validator
     */
    constructor(public navCtrl: NavController,
                private oauthService: OAuthService,
                public loadingCtrl: LoadingController,
                menu: MenuController,
                private fb: FormBuilder,
                public navParams: NavParams,
                public validator: InscriptionProvider,
                public createUser: RegisterService
                /*public userClass: User*/
                )
    {}

    /**
     *
     */
    ngOnInit() {
        //called after the constructor and called  after the first ngOnChanges()

        /* Validator */
        this.signForm = this.fb.group({
            'username': ['', Validators.compose([Validators.minLength(2), Validators.maxLength(15), Validators.pattern('[a-zA-Z0-9 ]*'), Validators.required])],
            'email': ['', Validators.compose([Validators.required, Validators.pattern(this.validator.regexEmail())])],

            'matching_password': this.fb.group({
                'confimpassword': ['', this.validator.matchPassword],
                'password': ['', Validators.compose([Validators.required, Validators.minLength(6)])]
            })

        });

        /**
         * Controls
         * @type {AbstractControl}
         */
        this.username = this.signForm.controls['username'];
        this.email = this.signForm.controls['email'];
        this.passwordGroup = this.signForm.controls['matching_password'];

    }


    ionViewDidLoad() {}

    /**
     *
     * @param value
     */
    onSubmit(value: string): void {

        this.showLoader(); // show loader

        let user : Object = {
            email: value['email'],
            username : value['username'],
            plainPassword : {
                first : value['matching_password']['password'],
                second : value['matching_password']['password']
            },
        };

        if (this.signForm.valid) {

            console.log(user);

            this.createUser.create(user).then(
                () => {
                    this.oauthService
                        .fetchTokenUsingPasswordFlow(value['username'],value['matching_password']['password'])
                        .then((resp) => {
                            this.loading.dismiss();
                            this.navCtrl.setRoot(AccueilPage);
                        })
                        .catch((err) => {
                            this.error = err._body;
                            this.setError(this.error);
                            this.loading.dismiss();
                        });
                }
            );
            // Traitement


        }else{
            console.log('Register problem');
        }

    }


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
    showLoader() {

        this.loading = this.loadingCtrl.create({
            content: ' Création...'
        });

        this.loading.present();
    }

}
