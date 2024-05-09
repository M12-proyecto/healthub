import React from 'react';
import { createRoot } from 'react-dom/client';
import './chat.module.css';

function Chat() {
  return (
    <div className="d-lg-flex">
      <div className="chat-leftsidebar me-lg-4">
        <div className="">
          <div className="py-4 border-bottom">
            <div className="d-flex">
              <div className="flex-shrink-0 align-self-center me-3">
                <img src="http://localhost:8000/assets/images/users/default.webp" className="avatar-xs rounded-circle" alt="" />
              </div>
              <div className="flex-grow-1">
                <h5 className="font-size-15 mb-1">Jose</h5>
                <p className="text-muted mb-0"><i className="mdi mdi-circle text-success align-middle me-1"></i> Active</p>
              </div>
            </div>
          </div>

          <div className="search-box chat-search-box py-4">
            <div className="position-relative">
              <input type="text" className="form-control" placeholder="Search..." />
              <i className="bx bx-search-alt search-icon"></i>
            </div>
          </div>

          <div className="chat-leftsidebar-nav">
            <ul className="nav nav-pills nav-justified">
              <li className="nav-item">
                <a href="#chat" data-bs-toggle="tab" aria-expanded="true" className="nav-link active">
                  <i className="bx bx-chat font-size-20 d-sm-none"></i>
                  <span className="d-none d-sm-block">Chat</span>
                </a>
              </li>
              <li className="nav-item">
                <a href="#contacts" data-bs-toggle="tab" aria-expanded="false" className="nav-link">
                  <i className="bx bx-book-content font-size-20 d-sm-none"></i>
                  <span className="d-none d-sm-block">Contacts</span>
                </a>
              </li>
            </ul>
            <div className="tab-content py-4">
              <div className="tab-pane show active" id="chat">
                <div>
                  <h5 className="font-size-14 mb-3">Recent</h5>
                  <ul className="list-unstyled chat-list" data-simplebar style={{ maxHeight: '410px' }}>
                    <li className="active">
                      <a href="#">
                        <div className="d-flex">
                          <div className="flex-shrink-0 align-self-center me-3">
                            <i className="mdi mdi-circle font-size-10"></i>
                          </div>
                          <div className="flex-shrink-0 align-self-center me-3">
                            <img src="http://localhost:8000/assets/images/users/default.webp" className="rounded-circle avatar-xs" alt="" />
                          </div>
                          <div className="flex-grow-1 overflow-hidden">
                            <h5 className="text-truncate font-size-14 mb-1">Steven Franklin</h5>
                            <p className="text-truncate mb-0">Hey! there I'm available</p>
                          </div>
                          <div className="font-size-11">05 min</div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

              <div className="tab-pane" id="contacts">
                <h5 className="font-size-14 mb-3">Contacts</h5>
                <div data-simplebar style={{ maxHeight: '410px' }}>
                  <div className="mt-4">
                    <ul className="list-unstyled chat-list">
                      <li>
                        <a href="#">
                          <h5 className="font-size-14 mb-0">Dolores Minter</h5>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div className="w-100 user-chat">
        <div className="card">
          <div className="p-4 border-bottom ">
            <div className="row">
              <div className="col-md-4 col-9">
                <h5 className="font-size-15 mb-1">Steven Franklin</h5>
                <p className="text-muted mb-0"><i className="mdi mdi-circle text-success align-middle me-1"></i> Active now</p>
              </div>
              <div className="col-md-8 col-3">
                <ul className="list-inline user-chat-nav text-end mb-0">
                  <li className="list-inline-item d-none d-sm-inline-block">
                    <div className="dropdown">
                      <button className="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i className="bx bx-search-alt-2"></i>
                      </button>
                      <div className="dropdown-menu dropdown-menu-end dropdown-menu-md">
                        <form className="p-3">
                          <div className="form-group m-0">
                            <div className="input-group">
                              <input type="text" className="form-control" placeholder="Search ..." aria-label="Recipient's username" />
                              <button className="btn btn-primary" type="submit"><i className="mdi mdi-magnify"></i></button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </li>
                  <li className="list-inline-item  d-none d-sm-inline-block">
                    <div className="dropdown">
                      <button className="btn nav-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i className="bx bx-cog"></i>
                      </button>
                      <div className="dropdown-menu dropdown-menu-end">
                        <a className="dropdown-item" href="#">View Profile</a>
                        <a className="dropdown-item" href="#">Clear chat</a>
                        <a className="dropdown-item" href="#">Muted</a>
                        <a className="dropdown-item" href="#">Delete</a>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div>
            <div className="chat-conversation p-3">
              <ul className="list-unstyled mb-0" data-simplebar style={{ maxHeight: '486px' }}>
                <li>
                  <div className="chat-day-title">
                    <span className="title">Today</span>
                  </div>
                </li>

                <li className="right">
                  <div className="conversation-list">
                    <div className="dropdown">
                      <a className="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i className="bx bx-dots-vertical-rounded"></i>
                      </a>
                      <div className="dropdown-menu">
                        <a className="dropdown-item" href="#">Copy</a>
                        <a className="dropdown-item" href="#">Save</a>
                        <a className="dropdown-item" href="#">Forward</a>
                        <a className="dropdown-item" href="#">Delete</a>
                      </div>
                    </div>
                    <div className="ctext-wrap">
                      <div className="conversation-name">{/* Aquí va la lógica para obtener el nombre del usuario */}</div>
                      <p>
                        Hi, How are you? What about our next meeting?
                      </p>

                      <p className="chat-time mb-0"><i className="bx bx-time-five align-middle me-1"></i> 10:02</p>
                    </div>
                  </div>
                </li>

                <li>
                  <div className="conversation-list">
                    <div className="dropdown">
                      <a className="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i className="bx bx-dots-vertical-rounded"></i>
                      </a>
                      <div className="dropdown-menu">
                        <a className="dropdown-item" href="#">Copy</a>
                        <a className="dropdown-item" href="#">Save</a>
                        <a className="dropdown-item" href="#">Forward</a>
                        <a className="dropdown-item" href="#">Delete</a>
                      </div>
                    </div>
                    <div className="ctext-wrap">
                      <div className="conversation-name">Steven Franklin</div>
                      <p>
                        Yeah everything is fine
                      </p>

                      <p className="chat-time mb-0"><i className="bx bx-time-five align-middle me-1"></i> 10:06</p>
                    </div>
                  </div>
                </li>

                <li className="last-chat">
                  <div className="conversation-list">
                    <div className="dropdown">
                      <a className="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i className="bx bx-dots-vertical-rounded"></i>
                      </a>
                      <div className="dropdown-menu">
                        <a className="dropdown-item" href="#">Copy</a>
                        <a className="dropdown-item" href="#">Save</a>
                        <a className="dropdown-item" href="#">Forward</a>
                        <a className="dropdown-item" href="#">Delete</a>
                      </div>
                    </div>
                    <div className="ctext-wrap">
                      <div className="conversation-name">Steven Franklin</div>
                      <p>& Next meeting tomorrow 10.00AM</p>
                      <p className="chat-time mb-0"><i className="bx bx-time-five align-middle me-1"></i> 10:06</p>
                    </div>
                  </div>
                </li>

                <li className=" right">
                  <div className="conversation-list">
                    <div className="dropdown">
                      <a className="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i className="bx bx-dots-vertical-rounded"></i>
                      </a>
                      <div className="dropdown-menu">
                        <a className="dropdown-item" href="#">Copy</a>
                        <a className="dropdown-item" href="#">Save</a>
                        <a className="dropdown-item" href="#">Forward</a>
                        <a className="dropdown-item" href="#">Delete</a>
                      </div>
                    </div>
                    <div className="ctext-wrap">
                      <div className="conversation-name">Henry Wells</div>
                      <p>Wow that's great</p>
                      <p className="chat-time mb-0"><i className="bx bx-time-five align-middle me-1"></i> 10:07</p>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
            <div className="p-3 chat-input-section">
              <div className="row">
                <div className="col">
                  <div className="position-relative">
                    <input type="text" className="form-control chat-input" placeholder="Enter Message..." />
                    <div className="chat-input-links" id="tooltip-container">
                      <ul className="list-inline mb-0">
                        <li className="list-inline-item"><a href="#" title="Emoji"><i className="mdi mdi-emoticon-happy-outline"></i></a></li>
                        <li className="list-inline-item"><a href="#" title="Images"><i className="mdi mdi-file-image-outline"></i></a></li>
                        <li className="list-inline-item"><a href="#" title="Add Files"><i className="mdi mdi-file-document-outline"></i></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div className="col-auto">
                  <button type="submit" className="btn btn-primary btn-rounded chat-send w-md waves-effect waves-light"><span className="d-none d-sm-inline-block me-2">Send</span> <i className="mdi mdi-send"></i></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

const chat = document.getElementById("chat");
if (chat) {
  const Index = createRoot(chat);

  Index.render(
    <React.StrictMode>
      <Chat />
    </React.StrictMode>
  );
}