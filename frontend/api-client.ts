type ErrorResponse = {
  success: false;
  message: string;
};
type SuccessResponse<ViewType> = { success: true; data: ViewType };
type Response<ViewType> = SuccessResponse<ViewType> | ErrorResponse;

type PayDayView = {
  payDate: Date;
  paymentDate: Date;
};

export const ApiClient = {
  payday: (_year: string, _month: string): Response<PayDayView> => {
    fetch("/api/payday");
    return {
      success: false,
      message: "no",
    };
  },
};
