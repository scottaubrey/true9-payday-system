type ErrorResponse = {
  message: string;
};
type SuccessResponse<ViewType> = { data: ViewType };
type Response<ViewType> = SuccessResponse<ViewType> | ErrorResponse;

type DateString = string;

type PayDayView = {
  payDate: DateString;
  paymentDate: DateString;
};

export const ApiClient = {
  payday: (_year: string, _month: string): Response<PayDayView> | undefined => {
    return undefined;
  },
};
