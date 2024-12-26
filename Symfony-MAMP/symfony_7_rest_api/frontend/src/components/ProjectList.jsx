import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Swal from "sweetalert2";
import { useNavigate } from 'react-router-dom';

const ProjectList = () => {
  const [projects, setProjects] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    axios
      .get('http://localhost:8007/api/projects')
      .then((response) => {
        if (Array.isArray(response.data)) {
          setProjects(response.data);
        } else {
          console.error('Expected an array, but got:', response.data);
        }
      })
      .catch((error) => console.error('Error:', error));
  }, []);

  const handleEdit = (projectId) => {
    // Logic to handle edit
    navigate(`/edit-project/${projectId}`);

    console.log('Edit project with id:', projectId);
  };

  const handleDelete = (projectId) => {
    // Logic to handle delete
    Swal.fire({
      title: "Are you sure you want to delete this project?",
      showCancelButton: true,
    }).then((result) => {
      if (result.isConfirmed) {
        // Send a request to delete the project
        axios
          .delete(`http://localhost:8007/api/projects/${projectId}`)
          .then(() => {
            // Update state to reflect the deletion
            setProjects(projects.filter((project) => project.id !== projectId));
            Swal.fire("Deleted!", "", "success");
          })
          .catch((error)=>{
            console.log("Error:", error);
          });
        } else if (result.isDenied) {
          Swal.fire("Saved", "", "info");
        }
      });
    };
    
    
  
   

  return (
    <div>
      <h1>Project List</h1>
      <table>
        <thead>
          <tr>
            <th>Project Name</th>
            <th>Description</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          {projects.map((project) => (
            <tr key={project.id}>
              <td>{project.name}</td>
              <td>{project.description}</td>
              <td>
                <button name="edit" onClick={() => handleEdit(project.id)}>Edit</button>
                <button name= "delete" onClick={() => handleDelete(project.id)}>Delete</button>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
};

export default ProjectList;