import Modal from "@/Components/Modal";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { useForm } from "@inertiajs/react";

function Delete({ task }) {
  const [isOpen, setIsOpen] = useState(false);

  const modalClose = () => {
    setIsOpen(false);
  };

  const { data, setData, post, reset, clearErrors, processing, errors } = useForm();

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
              <h2 className="text-center text-gray-800 text-2xl font-bold pt-6">Delete Task</h2>
              <form className="w-5/6 m-auto" onSubmit={handleSubmit}>
                <p className="text-center text-gray-500 pt-5">
                  Are you sure you want to delete the task: <strong>{task.title}</strong>?
                </p>

                <div className="flex justify-center mt-6">
                  <PrimaryButton type="submit" disabled={processing}>
                    Confirm Delete
                  </PrimaryButton>
                </div>

                <div className="flex justify-center mt-4">
                  <button
                    type="button"
                    className="text-sm text-gray-500 hover:text-gray-700 underline"
                    onClick={modalClose}
                  >
                    Cancel
                  </button>
                </div>
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

export default Delete;

