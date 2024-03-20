import { defineStore } from 'pinia';

export const UserStore = defineStore({
    id: 'UserStoreId',
    state: ()=>({
        token : localStorage.getItem('token') || 0,
        user_id : localStorage.getItem('user_id') || 0,
        name : localStorage.getItem('name') || 0,
        email : localStorage.getItem('email') || 0,
        company_name :  'LPS',
        theme: 'light',
        msgbox : false,
        today : new Date().toJSON().slice(0,10),// .replace(/-/g,'/'),
        last_Meeting_no: localStorage.getItem('last_Meeting_no') || 'INV 100',
        last_payment_ref: localStorage.getItem('last_payment_ref') || 'PAY 100',
        company_details: localStorage.getItem('company_details') || ''
    }),
    getters: {
        getToken : state => state.token, 
        getMsgbox : state => state.msgbox,
        getDate : (state) => {
            
            const todayArray = state.today.split('/');
            return todayArray[2]+"/"+todayArray[1]+"/"+todayArray[0];
        },
    },
    actions: {
        setToken: function(token, user){
            this.token = token
            localStorage.setItem('token',token)
            this.user_id = user.id
            this.name = user.name
            this.email = user.email
            localStorage.setItem('name',user.name)
            localStorage.setItem('email',user.email)
            localStorage.setItem('user_id',user.id)
        },
        setMeetingNo: function(no){ 
            this.last_Meeting_no = this.increment_aphanumberic(no)
            localStorage.setItem('last_Meeting_no',this.last_Meeting_no)
        },
        setPaymentRef: function(ref){
            this.last_payment_ref = this.increment_aphanumberic(ref)
            localStorage.setItem('last_payment_ref',this.last_payment_ref)
        },
        setCompanyDetails: function(data){
            this.company_details = JSON.stringify(data)
            localStorage.setItem('company_details',this.company_details)
        },
        setTheme: function(name){ 
            localStorage.setItem('theme', name)
        },
        increment_aphanumberic: (value)=>{
            value = value.replace(/(\d+)$/, function (match, n) {
                return ++n;  
            }); 
            return value;
        },
        removeToken: function(){
            this.token = 0 
            localStorage.removeItem('token')
            localStorage.removeItem('name')
            localStorage.removeItem('email')
            localStorage.removeItem('last_Meeting_no')
            localStorage.removeItem('last_payment_ref')
        },
        setMsgbox: function(data){
            this.msgbox = data
            setTimeout(() => {
                this.msgbox = false;
              }, 5000); 
        },
    }
})
