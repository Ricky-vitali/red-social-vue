import { URL } from '@/constants';

const postService = {

    getAll () {
        return fetch(`${ URL }auth/posts`,{
            method: 'GET',
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
          return { ...res }
        })
    },

    byId (id) {
        return fetch(`${ URL }auth/posts/${ id }`,{
            method: 'GET',
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
            if(res.success){
                return { ...res }
            }else{
                this.$router.push('/');
            }
          
        })
    },

    post (data) {
        return fetch(`${ URL }auth/posts/create`,{
            method: 'POST',
            body: JSON.stringify({
                content: data.content,
            }),
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
            if(res.success){
                return {success:true}
            }else{
                if(res.errors){
                    return {
                        success:false,
                        errors:res.errors
                    }
                }else if(res.errors_validation){
                    return {
                        success:false,
                        errors_validation:res.errors_validation
                    }
                }else{
                    return {
                        success:false,
                        errors:'Opss... ocurrio un problema.'
                    }
                }
                
            }
        })
    },

    delete(id){
        return fetch(`${ URL }auth/posts/delete/${ id }`,{
            method: 'DELETE',
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
            if(res.success){
                return {success:true}
            }else{
                if(res.errors){
                    return {
                        success:false,
                        errors:res.errors
                    }
                }else if(res.errors_validation){
                    return {
                        success:false,
                        errors_validation:res.errors_validation
                    }
                }else{
                    return {
                        success:false,
                        errors:'Opss... ocurrio un problema.'
                    }
                }
            }
        })
    }

}

export default postService;