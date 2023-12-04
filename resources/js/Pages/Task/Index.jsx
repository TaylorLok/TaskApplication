import Modal from "@/Components/Modal";
import { useState } from "react";
import InputError from "@/Components/InputError";
import PrimaryButton from "@/Components/PrimaryButton";
import { Link, useForm } from "@inertiajs/react";

function Index({ tasks }) {
  let [isOpen, setIsOpen] = useState(false);

  const modalClose = () => {
    setIsOpen(false);
  };

  const { data, setData, post, reset, clearErrors, processing, errors } =
    useForm({
      title: "",
      description: "",
    });

  function handleSubmit(e) {
    e.preventDefault();
    post("/task", {
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
      <div className="h-full">
        <div className="md:w-[60%] m-auto  pt-4">
          <div className="bg-white shadow-2xl rounded-b-3xl">
            <h2 className="text-center text-gray-800 text-2xl font-bold pt-6">
              To-do List
            </h2>
            <div className="w-5/6 m-auto">
              <p className="text-center text-gray-500 pt-5">
                {tasks && tasks.length ? (
                  <>
                    {tasks.length} Total,{" "}
                    {tasks.filter((t) => t.status === 1).length} Completed,{" "}
                    {tasks.filter((t) => t.status === 0).length} Pending
                  </>
                ) : (
                  "Loading..."
                )}
              </p>
              {console.log('Tasks:', tasks)}
            </div>
            <div className="bg-blue-700 w-52 lg:w-5/6 m-auto mt-6 p-2 hover:bg-indigo-500 rounded-2xl  text-white text-center shadow-xl shadow-bg-blue-700" onClick={() => setIsOpen(true)}>
              <button className="lg:text-sm text-lg font-bold">Add To-Do</button>
            </div>
            <div className="grid w-full lg:w-5/6 m-auto bg-indigo-50 mt-5 p-4 lg:p-4 rounded-2xl">
              <div className="flex flex-col">
                <div className="-m-1.5 overflow-x-auto">
                  <div className="p-1.5 min-w-full inline-block align-middle">
                    <div className="overflow-hidden">
                      {tasks.length === 0 ? (
                        <div>
                          <p>No todos available</p>
                        </div>
                      ) : (
                        <table className="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                          <thead>
                            <tr>
                              <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase hidden md:block">
                                Num
                              </th>
                              <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Title
                              </th>
                              <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Description
                              </th>
                              <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Status
                              </th>
                              <th scope="col" className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                Completion Date
                              </th>
                              <th scope="col" className="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase hidden md:block">
                                Delete
                              </th>
                            </tr>
                          </thead>
                          <tbody className="divide-y divide-gray-200 dark:divide-gray-700">
                            {tasks.map((taskItem, index) => (
                              <tr key={taskItem.id}>
                                <td className="px-4 whitespace-nowrap text-sm font-medium hidden md:block">{index + 1}</td>
                                <td className="px-4 whitespace-nowrap text-sm">{taskItem.title}</td>
                                <td className="px-4 whitespace-nowrap text-sm">{taskItem.description}</td>
                                <td className="px-4 whitespace-nowrap text-sm">{taskItem.status === 1 ? "Complete" : "Incomplete"}</td>
                                <td className="px-4 whitespace-nowrap text-sm">{new Date(taskItem.created_at).toLocaleDateString()}</td>
                                <td className="px-6 py-4 whitespace-nowrap text-right text-sm font-medium hidden md:block">
                                  <Link href={`/task/${taskItem.id}`} as="button" type="button" className="m-2">
                                    Edit
                                  </Link>
                                  <Link href={`/task/${taskItem.id}`} method="delete" as="button" type="button">
                                    Delete
                                  </Link>
                                </td>
                              </tr>
                            ))}
                          </tbody>
                        </table>
                      )}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Modal show={isOpen}>
        <form class="w-[90%] p-6" onSubmit={handleSubmit}>
          <div class="flex items-center border-b border-teal-500 py-2">
            <input
              class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none"
              type="text"
              placeholder="Task..."
              aria-label="task"
              value={data.title}
              onChange={(e) => setData("title", e.target.value)}
              isFocused={true}
            />
            <PrimaryButton disabled={processing}>Submit</PrimaryButton>
            <button
              class="flex-shrink-0 border-transparent border-4 text-teal-500 hover:text-teal-800 text-sm py-1 px-2 rounded"
              type="button"
              onClick={() => {
                modalClose();
                clearErrors();
              }}
            >
              Cancel
            </button>
          </div>
        </form>
      </Modal>
    </>
  );
}

export default Index;
