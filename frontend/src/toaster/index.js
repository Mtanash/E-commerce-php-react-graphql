import toast from "react-hot-toast";

const toaster = {
  success: (message) => toast.success(message),
  error: (message) => toast.error(message),
};

export default toaster;
