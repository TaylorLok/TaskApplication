import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, useForm } from "@inertiajs/react";

function Show({auth,task}) {
    const {data, setData, put,reset,processing, errors} = useForm({
        title:task.title,
        description:task.description,
        status:task.status
    });
    function handleSubmit(e){
        e.preventDefault();
        put(`/task/${task.id}`,{
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => reset(),
          });
    }
    return ( <>
        <AuthenticatedLayout user={auth}>
        <Head title={task.title}/>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <form className='flex flex-col items-center justify-center m-4' onSubmit={handleSubmit}>
                            <div className='container w-[70%]'>
                                <InputLabel htmlFor="title" value="Title"></InputLabel>
                                <TextInput
                                    id="title"
                                    type="title"
                                    name="title"
                                    placeholder="Title"
                                    className="mt-1 block w-full p-2"
                                    value={data.title}
                                    onChange={e => setData('title', e.target.value)}
                                    isFocused={true}
                                />
                                <InputError message={errors.title} className="mt-2" />
                            </div>
                            <div className='container w-[70%]'>
                                <InputLabel htmlFor="description" value="Description"></InputLabel>
                                <TextInput
                                    id="description"
                                    type="description"
                                    name="description"
                                    placeholder="Description"
                                    className="mt-1 block w-full p-2"
                                    value={data.description}
                                    onChange={e => setData('description', e.target.value)}
                                />
                                <InputError message={errors.description} className="mt-2" />
                            </div>
                            <div className='container w-[70%]'>
                                <InputLabel htmlFor="status" value="Status"></InputLabel>
                                <select
                                    id="status"
                                    type="status"
                                    name="status"
                                    className="mt-1 block w-full p-2"
                                    value={data.status}
                                    onChange={e => setData('status', e.target.value)}
                                >
                                    <option value="0">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                                <InputError message={errors.status} className="mt-2" />
                            </div>
                            <PrimaryButton disabled={processing}>Submit</PrimaryButton>
                        </form>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
    </> );
}

export default Show;
