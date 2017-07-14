import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import 'rxjs/add/operator/map';
import {FormGroup} from "@angular/forms";
import {RegisterService} from "../app/services/register.service";

/*
  Generated class for the InscriptionProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 cd pu
 DI.
*/
@Injectable()
export class InscriptionProvider {

  constructor(public http: Http, public userService: RegisterService) {
    console.log('Hello InscriptionProvider Provider');
    //console.log(userService.getUsers());
  }

  /**
   * Function: vérifie l'adresse mail
   * @returns {string}
   */
  regexEmail():any {

    var emailRegex = '^[a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,15})$';
    return emailRegex;
  }


  /**
   * Function: vérifie la confirmation mot de passe
   * @param group
   * @returns {any}
   */
  matchPassword(group: FormGroup): any {

    if (!group.parent) {
      return {"password": true}
    };

    let password = group.parent.controls['password'].value;
    let confirm = group.parent.controls['confimpassword'].value;

    if ((password && confirm) && (password != confirm)) {
      return {"password": true};
    } else {
      return null;
    }

  }

}
