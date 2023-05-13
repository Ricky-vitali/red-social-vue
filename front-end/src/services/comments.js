import { URL } from '@/constants';

const commentService = {

    comment (data) {
        return fetch(`${ URL }auth/comments/create`,{
            method: 'POST',
            body: JSON.stringify({
                post_id: data.post_id,
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
        return fetch(`${ URL }auth/comments/delete/${ id }`,{
            method: 'DELETE',
            credentials: 'include'
        }).then(rta => rta.json())
        .then(res => {
            if(res.success){
                return {success:true}
            }else{
                return {
                    success:false,
                    errors:res.errors
                }
            }
        })
    }

}

export default commentService;