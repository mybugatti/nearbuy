/**
 * Created by Bugatti on 29/07/2017.
 */
import { Injectable } from '@angular/core';
import { Http } from "@angular/http";
import 'rxjs/add/operator/toPromise';
import { BaseService } from "./base.service";
import {OAuthService} from "angular-oauth2-oidc";

@Injectable()
export class RegisterService extends BaseService{

    constructor(private http: Http, oauthService: OAuthService){
        super(oauthService);
    }

    // parent function based on class name don't work after npm build so override it until abstract solution is found
    getEntityName(){
        return 'register';
    }

    create(user : Object): Promise<Object> {
        return this.http
            .post(this.getEntityUrl(), this.serialize(user), {headers: this.headers})
            .toPromise()
            .then(res => res.json())
            .catch(this.handleError);
    }

    protected serialize(obj : Object): String {
        var str = [], p;
        for(p in obj) {
            if (obj.hasOwnProperty(p)) {
                var k = p, v = obj[p];
                if(v != null && k != "id"){
                    if(v !== null && typeof v === "object"){
                        if(k == 'plainPassword'){
                            var id;
                            for(id in v){
                                str.push(this.prefix + "account[" + k + "][" + id + "]=" + encodeURIComponent(v[id]));
                            }
                        } else {
                            str.push(this.serialize(v));
                        }
                    } else {
                        str.push(this.prefix + "account[" + k + "]=" + encodeURIComponent(v));
                    }
                }
            }
        }
        return str.join("&");
    }
}