import { Injectable } from '@angular/core';
import {Http} from '@angular/http';
import 'rxjs/add/operator/map';
import {OAuthService} from "angular-oauth2-oidc";

/*
  Generated class for the ConnexionProvider provider.

  See https://angular.io/docs/ts/latest/guide/dependency-injection.html
  for more info on providers and Angular 2 DI.
*/
@Injectable()
export class ConnexionProvider {
    /**
     *
     * @param http
     * @param storage
     */
  constructor(public http: Http, public oauthService: OAuthService) {
    console.log('Hello ConnexionProvider Provider');
  }

  /**
   *
   */
    logout(){
      sessionStorage.clear();
    }
}
