import { URL } from '@/constants';

let userSession = {
    id: null,
    user: null,
    name: null,
    surname: null,
    email: null
}

const authService = {

    login(email, password) {
        return fetch(`${URL}auth/login`, {
            method: 'POST',
            body: JSON.stringify({
                email: email,
                password: password
            }),
            credentials: 'include'
        })
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    userSession.id = res.user.id;
                    userSession.user = res.user.id;
                    userSession.name = res.user.id;
                    userSession.surname = res.user.id;
                    userSession.email = res.user.id;

                    return {success:true}
                }else{

                    if(res.errors){

                        return  {
                            success: false,
                            errors: res.errors
                        }
                    }else if(res.errors_validation){
                        return  {
                            success: false,
                            errors_validation: res.errors_validation
                        }
                    }else{
                        return  {
                            success: false,
                            errors: 'Opss... Ocurrio un problema.'
                        }
                    }
                
                }
            });
            
    },

     /**
   * Desloguea al usuario.
   *
   * @return {Promise<Response | never>}
   */
    logout () {
        // return fetch(`${API}/logout.php`, {
        return fetch(`${URL}auth/logout`, {
        method: 'DELETE',
        credentials: 'include'
        })
        .then(res => res.json())
        .then(res => {

            if(res.success){

                userSession.id = null;
                userSession.user = null;
                userSession.name = null;
                userSession.surname = null;
                userSession.email = null;
                return {success:true}
            }else{
                return  {
                    success: false,
                    errors: res.errors
                }
            }

        })
    },

    verificarAutenticacion() {
        return fetch(`${URL}auth/getAuth`, {
            method: 'GET',
            credentials: 'include'
            })
            .then(res => res.json())
            .then(res => {
                if(res.success !== false){
                    userSession.id = res.user.id;
                    userSession.user = res.user.user;
                    userSession.name = res.user.name;
                    userSession.surname = res.user.surname;
                    userSession.email = res.user.email;
    
                    return userSession;
                }else{

                    userSession.id = null;
                    userSession.user = null;
                    userSession.name =null;
                    userSession.surname = null;
                    userSession.email = null;

                    return null;
                }
    
            })
    },

}

export default authService;