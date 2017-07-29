/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import {OAuthService} from "angular-oauth2-oidc";
import {Favourite} from "../class/favourite";

@Injectable()
export class FavouriteEntrepriseService extends BaseService{
    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    protected getEntityUrl(){
        return this.baseUrl + 'account/favouriteentreprise';
    }

    create(favourite: Favourite): Promise<Favourite> {
        const url = `${this.getEntityUrl()}/${favourite}`;
        return this.http
            .post(url, this.serialize(favourite), {headers: this.headers})
            .toPromise()
            .then(() => null)
            .catch(this.handleError);
    }

    remove(id: number): Promise<void> {
        const url = `${this.getEntityUrl()}/${id}`;
        return this.http.delete(url, {headers: this.headers})
            .toPromise()
            .then(() => null)
            .catch(this.handleError);
    }
}