import { autoinject, inject, LogManager, NewInstance } from 'aurelia-framework';
import { Logger } from 'aurelia-logging';

export class Pokemon {
    public id: number;
    public number: number;
    public name: string;
    public nameFr: string;
    public form: string;
    public type1: Type;
    public type2: Type;
    public image: string;
    public hp: number;
    public attack: number;
    public defense: number;
    public spAtk: number;
    public spDef: number;
    public speed: number;
    public total: number;
    public coverage: any;

    public constructor(data: any = null) {
        if (data !== null) {
            this.id = data.id;
            this.number = data.number;
            this.name = data.name;
            this.nameFr = data.nameFr;
            this.form = data.form;
            this.type1 = data.type1;
            this.type2 = data.type2;
            this.image = data.image;
            this.hp = data.hp;
            this.attack = data.attack;
            this.defense = data.defense;
            this.spAtk = data.spAtk;
            this.spDef = data.spDef;
            this.speed = data.speed;
            this.total = data.total;

        }
    }
}

export class Type {
    public id: number;
    public name: string;
    public nameFr: string;
    public coverages: Coverage[];

    public constructor(data: any = null) {
        if (data !== null) {
            this.id = data.id;
            this.name = data.name;
            this.nameFr = data.nameFr;
            this.coverages = data.coverages;
        }
    }
}

export class Coverage {
    public id: number;
    public targetTypeId: number;
    public status: string;

    public constructor(data: any = null) {
        if (data !== null) {
            this.id = data.id;
            this.targetTypeId = data.targetTypeId;
            this.status = data.status;
        }
    }
}