type ErrorResponse = {
  success: false;
  error: string;
};
type SuccessResponse<ViewType> = { success: true; data: ViewType };
type Response<ViewType> = SuccessResponse<ViewType> | ErrorResponse;

type PayDayView = {
  payDate: Date;
  paymentDate: Date;
};

export const ApiClient = {
  payday: async (
    _year: string,
    _month: string,
  ): Promise<Response<PayDayView>> => {
    const response = await fetch("/api/payday");
    const data = await response.json();
    if (response.status !== 200) {
      return {
        success: false,
        error: data.message,
      };
    }
    return {
      success: true,
      data: {
        payDate: new Date(data.payDate),
        paymentDate: new Date(data.paymentDate),
      },
    };
  },
};
