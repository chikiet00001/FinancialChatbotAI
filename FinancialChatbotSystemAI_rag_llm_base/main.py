# # chuẩn bị dữ liệu
# from ingestion.ingestion import Ingestion

# Ingestion("openai").ingestion_folder(
#     path_input_folder="demo\data_in",
#     path_vector_store="demo\data_vector",
# )

# chatbot
# api/main.py
from fastapi import FastAPI, Query
from pydantic import BaseModel
from chatbot.services.files_chat_agent import FilesChatAgent  # noqa: E402
from app.config import settings

settings.LLM_NAME = "openai"

# question = "Sáng 14-11 có sự kiện gì??"
def Chat_Bot_Output(_question):
    chat = FilesChatAgent("demo\data_vector").get_workflow().compile().invoke(
        input={
            "question": _question,
        }
    )
    return chat["generation"]

### tạo api
app = FastAPI(title="Finance Chatbot API")

class QuestionInput(BaseModel):
    question: str

@app.get("/")
def root():
    return {"message": "Finance RAG API đang hoạt động"}

@app.post("/ask")
async def ask_question(data: QuestionInput):
    answer = Chat_Bot_Output(data.question)
    return {"answer": answer}
###