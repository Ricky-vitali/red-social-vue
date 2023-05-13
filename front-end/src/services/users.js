import { URL } from '@/constants';

const userService = {

    register (data) {
        return fetch(`${ URL }users/register`,{
            method: 'POST',
            body: JSON.stringify({
                user: data.user,
                name: data.name,
                surname: data.surname,
                email: data.email,
                password: data.password,
                confirm_password: data.confirm_password,
            }),
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
          return { ...res }
        })
    },

    editUser(user){
        return fetch(`${ URL }auth/users/edit/user`,{
            method: 'PUT',
            body: JSON.stringify({
                user: user,
            }),
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
          return { ...res }
        })
    },

    editBiography(data){
        return fetch(`${ URL }auth/users/edit/biography`,{
            method: 'PUT',
            body: JSON.stringify({
                user: data.biography,
            }),
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
          return { ...res }
        })
    },

     getAllUsers() {
        return fetch(`${URL}auth/users`, {
            method: 'GET',
            credentials: 'include'
        }).then(rta => rta.json())
            .then(res => {
                return { ...res }
            })
    },

    

}

export default userService;