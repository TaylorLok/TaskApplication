import Modal from "@/Components/Modal";
import { useState } from "react";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Link, useForm } from "@inertiajs/react";

function Edit({ task }) {
  const [isOpen, setIsOpen] = useState(false);

  const modalClose = () => {
    setIsOpen(false);
  };

  const { data, setData, post, reset, clearErrors, processing, errors } = useForm({
    title: task.title,
    description: task.description,
  });

  function handleSubmit(e) {
    e.preventDefault();
    post(`/task/${task.id}`, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        setIsOpen(false);
        reset();
      },
    });
  }

  return (
    <>
      <div style={bgStyle}>
        <AuthenticatedLayout>
          <div className="h-full">
            <div className="md:w-[60%] m-auto pt-4">
              <h2 className="text-center text-gray-800 text-2xl font-bold pt-6">Edit Task</h2>
              <form className="w-5/6 m-auto" onSubmit={handleSubmit}>
                <div className="mb-4">
                  <label htmlFor="title" className="block text-gray-700 text-sm font-bold mb-2">
                    Title
                  </label>
                  <input
                    type="text"
                    id="title"
                    name="title"
                    className="border-2 border-gray-300 p-2 w-full"
                    value={data.title}
                    onChange={(e) => setData("title", e.target.value)}
                  />
                  <InputError message={errors.title} />
                </div>

                <div className="mb-4">
                  <label htmlFor="description" className="block text-gray-700 text-sm font-bold mb-2">
                    Description
                  </label>
                  <textarea
                    id="description"
                    name="description"
                    className="border-2 border-gray-300 p-2 w-full"
                    value={data.description}
                    onChange={(e) => setData("description", e.target.value)}
                  />
                  <InputError message={errors.description} />
                </div>

                <PrimaryButton type="submit" disabled={processing}>
                  Update Task
                </PrimaryButton>
              </form>
            </div>
          </div>
        </AuthenticatedLayout>
        <Modal show={isOpen} onClose={modalClose}>
        </Modal>
      </div>
    </>
  );
}

export default Edit;
