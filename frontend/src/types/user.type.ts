export default interface IUser {
    id: number;
    firstName: string;
    surname: string;
    email: string;
    phoneNumber: number;
    address1: string;
    address2?: string;
    city: string;
    state?: string;
    country: string;
    postcode?: string;
}