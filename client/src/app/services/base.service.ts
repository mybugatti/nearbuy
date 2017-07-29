/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import 'rxjs/add/operator/toPromise';
import { Headers} from "@angular/http";
import {OAuthService} from "angular-oauth2-oidc";

@Injectable()
export class BaseService {
    protected headers:Headers;
    protected prefix = "nearbuy_apibundle_";
    protected baseUrl = 'http://localhost:8000/api/';

    constructor(private oauthService: OAuthService){
        this.headers = new Headers({
            'Content-type': 'application/x-www-form-urlencoded',
            "Authorization": "Bearer " + this.oauthService.getAccessToken()
        });
    }

    protected serialize(obj : Object): String {
        var str = [], p;
        for(p in obj) {
            if (obj.hasOwnProperty(p)) {
                var k = p, v = obj[p];
                if(v != null && k != "id"){
                    if(v !== null && typeof v === "object"){
                        if(k == 'diffusionLocal'){
                            var id;
                            for(id in v){
                                str.push(this.prefix + this.getEntityName() + "[" + k + "][" + id + "][local]=" + encodeURIComponent(v[id]));
                            }
                        } else {
                            str.push(this.serialize(v));
                        }
                    } else {
                        str.push(this.prefix + this.getEntityName() + "[" + k + "]=" + encodeURIComponent(v));
                    }
                }
            }
        }
        return str.join("&");
    }

    protected handleError(error: any): Promise<any> {
        console.error('An error occurred', error); // for demo purposes only
        return Promise.reject(error.message || error);
    }

    protected getEntityName(){
        return this.constructor.name.slice(0, -7).toLowerCase();
    }

    protected getEntityUrl(){
        return this.baseUrl + this.getEntityName();
    }

}